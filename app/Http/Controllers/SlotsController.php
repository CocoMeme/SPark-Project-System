<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\SlotRental;
use Illuminate\Http\Request;

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

// USER SIDE //////////////////////////////////////////////////////////////////

    public function confirmRent(Request $request)
    {
        // Check if the user already has an active rental
        $alreadyRented = SlotRental::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->exists();
    
        if ($alreadyRented) {
            return redirect()->back()->withErrors(['error' => 'You already have an active rental.']);
        }
    
        // Proceed with renting the slot
        $slot = Slot::findOrFail($request->slot_id);
    
        // Update slot details
        $slot->status = 'occupied';
        $slot->updated_at = now();
        $slot->save();
    
        // Create a new SlotRental record
        $slotRental = new SlotRental();
        $slotRental->slot_id = $slot->id;
        $slotRental->user_id = auth()->id();
        $slotRental->start_time = now();
        $slotRental->save();
    
        // Redirect to the slots page after successful rental
        return redirect()->route('slots')->with('success', 'Slot rented successfully.');
    }
    
    public function endRent(Request $request)
    {
        // Find the slot rental record
        $slotRental = SlotRental::where('slot_id', $request->slot_id)
            ->where('user_id', auth()->id())
            ->whereNull('end_time') // Only consider rentals that are still active
            ->first();
    
        if (!$slotRental) {
            return redirect()->back()->withErrors(['error' => 'No active rental found for the specified slot.']);
        }
    
        // Update end time and update slot status
        $slotRental->update(['end_time' => now()]);
        $slot = Slot::findOrFail($request->slot_id);
        $slot->update(['status' => 'available']);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Rental ended successfully.');
    }

// ADMIN SIDE //////////////////////////////////////////////////////////////

    public function confirmRentAdmin(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create a new user with type "irregular"
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
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

    

}
