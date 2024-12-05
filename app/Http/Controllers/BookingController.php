<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function show(Booking $booking)
    {
        $booking = Booking::with('event')->get();
        return view('booking.booking', compact('booking'));
    }


    public function create()
    {
        $events = Event::all();
        return view('bookings.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');

        // Optionally save file path to the database
        // Example: PaymentProof::create(['file_path' => $filePath]);

        return redirect('user/dashboard')->with('success', 'Payment proof uploaded successfully');
    }
}
