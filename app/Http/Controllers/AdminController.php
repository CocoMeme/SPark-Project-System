<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\User;
use App\Models\Admin;
use App\Models\SlotRental;
use App\Models\UserMail;
use App\Models\Reservation;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.login');
    }

    public function showAdminSlot()
    {
        $slots = Slot::all();
        $rentals = SlotRental::with('user')->whereNull('end_time')->get();
        $reservations = Reservation::with('user')->whereNull('end_time')->get();
        return view('Admin.slotsControl', compact('slots', 'rentals', 'reservations'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/slots-control-admin');
        } else {
            return back()->withErrors(['error' => 'Invalid username or password']);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('Admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins',
            'password' => 'required|min:6',
        ]);

        try {
            $admin = new Admin();
            $admin->username = $request->username;
            $admin->password = bcrypt($request->password);
            $admin->save();

            return redirect()->route('login-admin')->with('success', 'Admin registration successful. Please log in.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to register admin. Please try again.']);
        }
    }


    // SLOT FUNCTIONALITIES

        // APPROVE

        public function approveRent(Request $request, $slotId)
        {
            // Find the slot
            $slot = Slot::findOrFail($slotId);

            // Update slot status to 'occupied'
            $slot->status = 'occupied';
            $slot->save();

            // Find the corresponding slot rental record
            $slotRental = SlotRental::where('slot_id', $slot->id)
                ->whereNull('end_time')
                ->firstOrFail();

            // Update slot rental status to 'approved'
            $slotRental->status = 'approved';
            $slotRental->save();

            // Create a new notification for the user
            $notification = new UserMail();
            $notification->user_id = $slotRental->user_id;
            $notification->type = 'Slot';
            $notification->title = 'Your rental request has been approved';
            $notification->content = "Your rental request for slot " . $slot->slot_number . " has been approved.
                We're excited to inform you that your rental request has been successfully approved! This means that you can now proceed with confidence, knowing that your desired rental arrangement has been confirmed.
                Our team has carefully reviewed your request and found everything to be in order. We understand the importance of timely approvals, and we're delighted to have the opportunity to assist you in securing your rental.
                With your request approved, you can now plan and prepare for your upcoming rental experience with ease. Whether it's a residential property, a commercial space, or any other type of rental, we're committed to ensuring that your experience is smooth and hassle-free.";
            $notification->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Rental request approved successfully.');
        }

    // RENT & RESERVATION HISTORY

    public function showAdminHistory()
    {
        $irregular = SlotRental::with(['user', 'slot'])
        ->whereHas('user', function ($query) {
            $query->where('type', 'irregular');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $regular = SlotRental::with(['user', 'slot'])
        ->whereHas('user', function ($query) {
            $query->where('type', 'regular');
        })
        ->orderBy('created_at', 'desc')
        ->get();


        return view('Admin.historyAdmin', compact('regular', 'irregular'));
    }

        // DELETE FUNCTION

            public function deleteSlotRental($id)
            {
                $regular = SlotRental::findOrFail($id);
                $regular->delete();
                return back()->with('success', 'Slot rental deleted successfully.');
            }

            public function deleteReservation($id)
            {
                $irregular = Reservation::findOrFail($id);
                $irregular->delete();
                return back()->with('success', 'Reservation deleted successfully.');
            }

        // UPDATE FUNCTION

            public function updateSlotRental(Request $request, $id)
            {
                $request->validate([
                    'start_time' => 'required|date',
                    'end_time' => 'required|date|after_or_equal:start_time',
                ]);

                $regular = SlotRental::findOrFail($id);
                $regular->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);

                return back()->with('success', 'Slot rental updated successfully.');
            }

            public function updateReservation(Request $request, $id)
            {
                $request->validate([
                    'start_time' => 'required|date',
                    'end_time' => 'required|date|after_or_equal:start_time',
                ]);

                $irregular = Reservation::findOrFail($id);
                $irregular->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);

                return back()->with('success', 'Reservation updated successfully.');
            }

    // USERMANAGEMENT

    public function showUserManagement()
    {
        $users = User::all(); // Fetch all users
        return view('Admin/usermanagementAdmin', compact('users')); // Pass users to the view
    }

    public function updateUser(Request $request, User $user)
    {
        // Validate the input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|min:6',
            'plate_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the user
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        if ($validatedData['password']) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->plate_number = $validatedData['plate_number'];
        $user->type = $validatedData['type'];
        $user->status = $validatedData['status'];

        if ($request->hasFile('image')) {
            $imageName = $user->id . '_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('profiles'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        // Create a record in user_mail if the user account has been verified
        if ($validatedData['status'] === 'verified') {
            UserMail::create([
                'user_id' => $user->id,
                'type' => 'Account',
                'title' => 'Account Verification',
                'content' => "We're pleased to inform you that your account has successfully completed the verification process. This means you now have full access to all the features and functionalities within our system.
                Verification is an important step in ensuring the security and integrity of our platform. By confirming your identity, we can better protect your account from unauthorized access and provide you with a seamless experience.
                Should you have any questions or require assistance with navigating our system, our support team is always available to help. Feel free to reach out to us at any time, and we'll be happy to assist you.
                Thank you for choosing SPark Management System. We look forward to serving you and helping you achieve your goals.",
            ]);
        }

        return redirect()->route('admin.user-management')->with('success', 'User updated successfully.');
    }


    public function deleteUser(User $user)
        {
            $user->delete(); // This deletes the user from the database
            return redirect()->route('admin.user-management')->with('success', 'User deleted successfully.');
        }


    // SUMMARY REPORT ///////////////////////////////////////////////

    public function showSummary() {
        $ratePerHour = 50;
        $additionalRatePerMinute = 1;
        $fixedMonthlyPayment = 4500;

        // Rentals
        $rentals = SlotRental::with('user')
        ->join('slots', 'slot_rentals.slot_id', '=', 'slots.id')
        ->selectRaw('
            slot_rentals.id,
            slots.slot_number AS slot_number,
            user_id,
            SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) AS total_minutes
        ')
        ->groupBy('slot_rentals.id', 'slots.slot_number', 'user_id')
        ->get()
        ->map(function ($rental) use ($ratePerHour, $additionalRatePerMinute) {
            if ($rental->user && $rental->user->type === 'irregular') {
                $totalMinutes = $rental->total_minutes;
                $rental->hours = intdiv($totalMinutes, 60);
                $rental->minutes = $totalMinutes % 60;
                $additionalMinutes = max($totalMinutes - 60, 0);
                $rental->additional_rate = $additionalMinutes * $additionalRatePerMinute;
                $rental->total = $ratePerHour * ($rental->hours ?: 1) + $rental->additional_rate; // dapat sure na  at least one hour is charged
                return $rental; // Balik sa  modified rental
            }
            return null; // This rental will be excluded because the user does not exist or is not irregular
        })
        ->filter();




        // Calculate grand totals
        $grandTotalRental = $rentals->sum('total');


        // Regular users monthly payment

        $currentMonth = Carbon::now()->format('Y-m');
        $regularUsers = User::with('latestPayment')
        ->where('type', 'regular')
        ->get()
        ->map(function ($user) use ($fixedMonthlyPayment, $currentMonth) {
            $latestPayment = $user->latestPayment;
            $user->slot_number = optional($latestPayment)->slot_number ?? 'N/A';
            $user->month = optional($latestPayment)->month ?? $currentMonth;
            $user->status = optional($latestPayment)->status ?? 'N/A';
            // Ensure that the fixed monthly payment is displayed
            $user->monthly_payment = $fixedMonthlyPayment; // This assigns the fixed monthly payment regardless of the latest payment status
            return $user;
        });



    $grandTotalRegular = $regularUsers->sum('monthly_payment');

        // Return the view with all the necessary variables
        return view('Admin.summary', [
             'rentals' => $rentals,
            'regularUsers' => $regularUsers,
            'grandTotalRegular' => $grandTotalRegular,
            'grandTotalRental' => $grandTotalRental,
            'ratePerHour' => $ratePerHour,
            'additionalRatePerMinute' => $additionalRatePerMinute
        ]);
    }





    public function generateSummaryReportPDF(Request $request){

        $ratePerHour = 50; // Base rate for up to one hour
        $additionalRatePerMinute = 1; // Additional rate per minute after the first hour
        $fixedMonthlyPayment = 4500; // Fixed monthly payment for regular users

        $reportMonth = $request->input('reportMonth', date('Y-m'));
        $year = Carbon::parse($reportMonth)->year;
        $month = Carbon::parse($reportMonth)->month;

        // Define the formattedMonth here
        $formattedMonth = Carbon::parse($reportMonth)->format('F Y');

            // Rentals
            $rentals = SlotRental::with('user')
            ->join('slots', 'slot_rentals.slot_id', '=', 'slots.id')
            ->selectRaw('
                slot_rentals.id,
                slots.slot_number AS slot_number,
                user_id,
                SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) AS total_minutes
            ')
            ->groupBy('slot_rentals.id', 'slots.slot_number', 'user_id')
            ->get()
            ->map(function ($rental) use ($ratePerHour, $additionalRatePerMinute) {
                if ($rental->user && $rental->user->type === 'irregular') {
                    $totalMinutes = $rental->total_minutes;
                    $rental->hours = intdiv($totalMinutes, 60);
                    $rental->minutes = $totalMinutes % 60;
                    $additionalMinutes = max($totalMinutes - 60, 0);
                    $rental->additional_rate = $additionalMinutes * $additionalRatePerMinute;
                    $rental->total = $ratePerHour * ($rental->hours ?: 1) + $rental->additional_rate; // dapat sure na  at least one hour is charged
                    return $rental; // Balik sa  modified rental
                }
                return null; // This rental will be excluded because the user does not exist or is not irregular
            })
            ->filter();




            // Calculate grand totals
            $grandTotalRental = $rentals->sum('total');


            // Regular users monthly payment

            $currentMonth = Carbon::now()->format('Y-m');
            $regularUsers = User::with('latestPayment')
            ->where('type', 'regular')
            ->get()
            ->map(function ($user) use ($fixedMonthlyPayment, $currentMonth) {
                $latestPayment = $user->latestPayment;
                $user->slot_number = optional($latestPayment)->slot_number ?? 'N/A';
                $user->month = optional($latestPayment)->month ?? $currentMonth;
                $user->status = optional($latestPayment)->status ?? 'N/A';
                // Ensure that the fixed monthly payment is displayed
                $user->monthly_payment = $fixedMonthlyPayment; // This assigns the fixed monthly payment regardless of the latest payment status
                return $user;
            });



        $grandTotalRegular = $regularUsers->sum('monthly_payment');

        $data = [
            'rentals' => $rentals,
            'regularUsers' => $regularUsers,
            'grandTotalRegular' => $grandTotalRegular,
            'grandTotalRental' => $grandTotalRental,
            'ratePerHour' => $ratePerHour,
            'additionalRatePerMinute' => $additionalRatePerMinute,
            'reportMonth' => $formattedMonth,


        ];

        //return view('pdf.summary', $data); // VIEW
        $pdf = PDF::loadView('pdf.summary', $data);
        return $pdf->download('summary-report-' . $reportMonth . '.pdf');
    }


    // USER REPORT ///////////////////////////////////////////////

    public function generateUserManagementReportPDF(Request $request){
        $reportMonth = $request->input('reportMonth', date('Y-m'));
        $year = Carbon::createFromFormat('Y-m', $reportMonth)->year;
        $month = Carbon::createFromFormat('Y-m', $reportMonth)->month;

        // Fetch users created in the selected month and year
        $users = User::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->get();

        $formattedMonth = Carbon::createFromFormat('Y-m', $reportMonth)->format('F Y'); // Convert to a readable format
        //yung carbon d ko sure kung ano yan hahaha kita ko lang yan sa lara cast
        $data = [
            'users' => $users,
            'reportMonth' => $formattedMonth
        ];


        $pdf = PDF::loadView('pdf.usermanage', $data);
        return $pdf->download('user-management-report-' . $reportMonth . '.pdf');
    }

}
