<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class BookingController extends Controller
{
    public function show($event_id)
    {
        $data = [
            'event_id' => $event_id,
        ];
        return view('booking.booking', $data);
    }

    public function create()
    {
        $events = Event::all();
        return view('bookings.create', compact('events'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');

        $currentDateTime = Carbon::now();

        // Check if the event is ongoing, finished, or not started
        $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time);
        $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time);

        $status = 'Ongoing';
        if ($currentDateTime->lt($startDateTime)) {
            $status = 'Not Started'; // Booking is before the event
        }

        if ($currentDateTime->gt($endDateTime)) {
            $status = 'Finished'; // Booking is after the event
        }

        // Find the booking for the logged-in user (assuming one active booking per user)
        $user = Auth::user();
        Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => $status,
            'payment_url' => $filePath,
        ]);

        // Optionally save file path to the database
        // Example: PaymentProof::create(['file_path' => $filePath]);

        return back()->with('success', 'Payment Uploaded successfully.');
    }
}
