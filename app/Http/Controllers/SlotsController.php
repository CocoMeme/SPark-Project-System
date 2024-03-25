<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\SlotRental;
use App\Models\Reservation;
use App\Models\UserMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class SlotsController extends Controller
{
    public function index()
    {
        $slots = Slot::all();
        return view('home', compact('slots'));
    }

    public function slot()
    {
        $slots = Slot::all();
        return view('Users/slots', compact('slots'));
    }

    public function showRentForm(Slot $slot)
    {
        return view('Users/rent', compact('slot'));
    }

    public function showReserveForm(Slot $slot)
    {
        return view('Users/reserve', compact('slot'));
    }

// USER SIDE //////////////////////////////////////////////////////////////////


public function confirmRent(Request $request)
{
    // Check if the user already has an active rental
    $alreadyRented = SlotRental::where('user_id', auth()->id())
        ->where(function ($query) {
            $query->whereNull('end_time')
                ->orWhere('status', 'pending'); // Check for pending status
        })
        ->exists();

    if ($alreadyRented) {
        return redirect()->back()->withErrors(['error' => 'You already have an active rental or a pending request.']);
    }

    // Proceed with renting the slot
    $slot = Slot::findOrFail($request->slot_id);

    // Update slot details
    $slot->status = 'pending'; // Set status to pending
    $slot->updated_at = now();
    $slot->save();

    // Create a new record in slot_rentals table with pending status
    $slotRental = new SlotRental();
    $slotRental->slot_id = $slot->id;
    $slotRental->user_id = auth()->id();
    $slotRental->start_time = now();
    $slotRental->status = 'pending'; // Set status to pending
    $slotRental->save();

    // Create a new notification for the user
    $notification = new UserMail();
    $notification->user_id = auth()->id();
    $notification->type = 'Slot';
    $notification->title = 'Slot Rental Request Sent';
    $notification->content = "We're pleased to inform you that your request to rent slot number " . $slot->slot_number . " has been successfully submitted. Our team will now review your request, and we kindly ask for your patience as we process it. Rest assured, we'll endeavor to provide you with a prompt response once your request has been reviewed and approved. Thank you for choosing our services, and we look forward to potentially accommodating your rental needs.";
    $notification->save();

    // Redirect to the slots page after successful rental request
    return redirect()->route('slots')->with('success', 'Slot rental request sent. Please wait for approval.');
}



    public function endRent(Request $request, $slotId)
    {
        // Find the slot rental record
        $slotRental = SlotRental::where('slot_id', $slotId)
            ->whereNull('end_time')
            ->first();

        if (!$slotRental) {
            // No active rental found for the slot, return with an error message
            return redirect()->back()->withErrors(['error' => 'No active rental found for the specified slot.']);
        }

        // Update end time and update slot status
        $slotRental->update(['end_time' => now()]);
        $slot = Slot::findOrFail($slotId);
        $slot->update(['status' => 'available']);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Renting ended successfully.');
    }


    public function confirmReserve(Request $request)
    {
        // Check if the user already has an active reservation
        $alreadyReserved = Reservation::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->exists();

        if ($alreadyReserved) {
            return redirect()->back()->withErrors(['error' => 'You already have an active reservation.']);
        }

        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'user_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Proceed with reserving the slot
        $slot = Slot::findOrFail($request->slot_id);

        // Update slot details
        $slot->status = 'reserved';
        $slot->updated_at = now();
        $slot->save();

        // Create a new Reservation record
        $reservation = new Reservation();
        $reservation->slot_id = $slot->id;
        $reservation->user_id = auth()->id();
        $reservation->start_time = $request->start_time;
        $reservation->end_time = $request->end_time;
        $reservation->save();

        // Redirect to the slots page after successful reservation
        return redirect()->route('slots')->with('success', 'Slot reserved successfully.');
    }


// ADMIN SIDE //////////////////////////////////////////////////////////////


    // RENT
    public function showRentAdminForm($slotId)
    {
        $slot = Slot::findOrFail($slotId);
        return view('Admin.rentAdmin', compact('slot'));
    }

    public function confirmRentAdmin(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'username' => 'required|unique:users',
            'plate_number' => 'required|unique:users',
        ]);

        // Create a new user with type "irregular"
        $user = new User();
        $user->username = $request->username;
        $user->plate_number = $request->plate_number;
        $user->type = 'irregular';
        $user->save();

        // Update the slot status
        $slot = Slot::findOrFail($request->slot_id);
        $slot->status = 'occupied';
        $slot->updated_at = now();
        $slot->save();

        // Create a new SlotRental record
        $slotRental = new SlotRental();
        $slotRental->slot_id = $slot->id;
        $slotRental->user_id = $user->id;
        $slotRental->start_time = now();
        $slotRental->save();

        // Redirect to the admin slots control page after successful rental
        return redirect()->route('slots-control-admin')->with('success', 'Slot rented successfully to irregular user.');
    }

    public function endRentingAdmin(Request $request, $slotId)
    {
        // Find the slot rental record
        $slotRental = SlotRental::where('slot_id', $slotId)
            ->whereNull('end_time')
            ->first();

        if (!$slotRental) {
            // No active rental found for the slot, return with an error message
            return redirect()->back()->withErrors(['error' => 'No active rental found for the specified slot.']);
        }

        // Update end time and update slot status
        $slotRental->update(['end_time' => now()]);
        $slot = Slot::findOrFail($slotId);
        $slot->update(['status' => 'available']);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Renting ended successfully.');
    }

    // RESERVE
    public function showReserveAdminForm($slotId)
    {
        $slot = Slot::findOrFail($slotId);
        $regularUsers = User::where('type', 'regular')->get();
        return view('Admin.reserveAdmin', compact('slot', 'regularUsers'));
    }

    public function confirmReserveAdmin(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'user_id' => 'required|exists:users,id,type,regular',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Update the slot status
        $slot = Slot::findOrFail($request->slot_id);
        $slot->status = 'reserved';
        $slot->updated_at = now();
        $slot->save();

        // Create a new Reservation record
        $reservation = new Reservation();
        $reservation->slot_id = $slot->id;
        $reservation->user_id = $request->user_id;
        $reservation->start_time = $request->start_time;
        $reservation->end_time = $request->end_time;
        $reservation->save();

        // Redirect to the admin slots control page after successful reservation
        return redirect()->route('slots-control-admin')->with('success', 'Slot reserved successfully for regular user.');
    }

    // CREATE ACCOUNT

    public function createSlot(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'slot_number' => 'required|unique:slots,slot_number|string|max:255',
            // Add more validation rules as needed
        ]);

        // Create a new slot record
        $slot = new Slot();
        $slot->slot_number = $request->slot_number;
        // Add any other fields you need to set for the slot
        $slot->save();

        // Redirect the user back with a success message
        return redirect()->route('slots-control-admin')->with('success', 'Slot created successfully.');
    }
<<<<<<< HEAD
    
=======

>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
    public function denySlotRequest($id)
    {
        // Find the slot by ID
        $slot = Slot::findOrFail($id);

        // Find the current rental associated with the slot
        $rental = $slot->currentRental();

        if ($rental) {
            // Delete the current rental
            $rental->delete();

            // Create a new record in user_mails to notify the user about the denial
            $userMail = new UserMail();
            $userMail->user_id = $rental->user_id;
            $userMail->type = 'Slot';
            $userMail->title = 'Slot Request Denied';
            $userMail->content = 'Your request for slot ' . $slot->slot_number . ' has been denied. We regret to inform you that your request cannot be accommodated at this time. Please feel free to contact us for further assistance.';
            $userMail->save();
        }

        // Update the slot status to 'available' since the request is denied
        $slot->status = 'available';
        $slot->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Slot request denied successfully.');
    }
<<<<<<< HEAD
=======

>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4


}
