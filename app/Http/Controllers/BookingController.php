<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function index(){

        $bookings = Booking::all();

        return view('myAdmin.booking.index', ['bookings' => $bookings]);
    }
    public function show(Event $event)
    {
        return view('booking.booking', ['event'=> $event]);
    }

    public function create()
    {
        $events = Event::where('is_shown', 1)->get();
        $users = User::all();
        return view('myAdmin.booking.form', compact('events'), compact('users'));
    }

    public function edit(Booking $booking)
    {
        $events = Event::where('is_shown', 1)->get();
        $users = User::all();
        return view('myAdmin.booking.form', [
            'events' => $events,
            'users' => $users,
            'booking' => $booking
        ]);
    }

    public function validate(Booking $booking){
        if($booking->is_payment_validated == 1){
            $booking->update([
                'is_payment_validated' => 0
            ]);
        }else{
            $booking->update([
                'is_payment_validated' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Payment validation is updated.');

    }

    public function add(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::where('id', $request->event_id)->first();

        if($event->price > 0){
            $request->validate([
                'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');
        }

        $user = User::where('id', $request->user_id)->first();
        $event = Event::where('id', $request->event_id)->first();

        $currentDateTime = Carbon::now();

        // Check if the event is ongoing, finished, or not started
        $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time);
        $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time);

        $status = 'ongoing';
        if ($currentDateTime->lt($startDateTime)) {
            $status = 'not Started'; // Booking is before the event
        }

        if ($currentDateTime->gt($endDateTime)) {
            $status = 'finished'; // Booking is after the event
        }

        // Find the booking for the logged-in user (assuming one active booking per user)

        Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => $status,
            'payment_url' => isset($filePath) ? $filePath : "",
        ]);

       

        return response()->json([
            'success' => true,
            'message' => 'Event booked successfully!',
        ], 200);
    }   

    public function update(Request $request, Booking $booking){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::where('id', $request->event_id)->first();

        if($event->price > 0){
            $request->validate([
                'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');
        }

        $user = User::where('id', $request->user_id)->first();
        $event = Event::where('id', $request->event_id)->first();

        $currentDateTime = Carbon::now();

        // Check if the event is ongoing, finished, or not started
        $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time);
        $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time);

        $status = 'ongoing';
        if ($currentDateTime->lt($startDateTime)) {
            $status = 'not Started'; // Booking is before the event
        }

        if ($currentDateTime->gt($endDateTime)) {
            $status = 'finished'; // Booking is after the event
        }

        // Find the booking for the logged-in user (assuming one active booking per user)

        $booking->update([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => $status,
            'payment_url' => isset($filePath) ? $filePath : "",
        ]);

       

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully!',
        ], 200);
    }  

    public function remove(Booking $booking){

        $booking->delete();

        return redirect()->back()->with('success', 'Booking removed successfully.');

    }



    public function store(Request $request, Event $event)
    {
      
        $user = User::where('id', Auth::user()->id)->first();
       
        $userBooking = Booking::where('user_id', $user->id)->where('event_id', $event->id)->first();
        if($userBooking){
            return response()->json([
                'success' => false,
                'message' => 'You have booked this event.',
            ]);
        }
        $request->validate([
            'line-id' => 'required',
            'phone-number' => 'required',
        ]);

        $user->update([
            'line_id' => $request->line_id,
            'phone_number' => $request->phone_number,
        ]);

        if($event->price > 0){
            $request->validate([
                'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }

        // Handle file upload
        $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');

        $currentDateTime = Carbon::now();

        // Check if the event is ongoing, finished, or not started
        $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time);
        $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time);

        $status = 'ongoing';
        if ($currentDateTime->lt($startDateTime)) {
            $status = 'not Started'; // Booking is before the event
        }

        if ($currentDateTime->gt($endDateTime)) {
            $status = 'finished'; // Booking is after the event
        }

        // Find the booking for the logged-in user (assuming one active booking per user)
        
        Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => $status,
            'payment_url' =>  isset($filePath) ? $filePath : "",
        ]);

        // Optionally save file path to the database
        // Example: PaymentProof::create(['file_path' => $filePath]);

        return response()->json([
            'success' => true,
            'message' => 'Event booked successfully!',
        ], 200);
    }

    public function toggleBooking($booking) {
        $booking->is_payment_validated = !$booking->is_payment_validated;
        $booking->save();
        return redirect()->route('organizer.events');
    }
}
