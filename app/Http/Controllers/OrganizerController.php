<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('organizer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('organizer.login');
    }
    
    public function showLoginForm()
    {
        return view('organizer.login');
    }

    public function login(Request $request){
         // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');


        if (Auth::guard('organizer')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('organizer.events')->with('success', 'Login successful');
        }
        return back()->with('error', 'Invalid email or password');
    }

    public function showEvents () {
        $id = Auth::guard('organizer')->user()->id;
        $events = Event::where('organizer_id', $id)->get();
        $categories = EventCategory::all();
        $tags = Tag::all();
        return view('organizer.events', compact('events', 'categories', 'tags'));
    }


    /**
     * Display a listing of the resource.
     */
    public function index(){

        $organizers = Organizer::all();

        return view('myAdmin.organizer.index', ['organizers' => $organizers]);
    }

    // public function create()
    // {
    //     return view('myAdmin.organizer.form');
    // }

    public function toggleActivate(Organizer $organizer)
    {
        if($organizer->active ==1){
            $organizer->update([
                'active' => 0,
            ]);
        } else {
            $organizer->update([
                'active' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Organizer updated successfully.');
    }
    // public function add(Request $request){
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'event_id' => 'required|exists:events,id',
    //     ]);

    //     $event = Event::where('id', $request->event_id)->first();

    //     if($event->price > 0){
    //         $request->validate([
    //             'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');
    //     }

    //     $user = User::where('id', $request->user_id)->first();
    //     $event = Event::where('id', $request->event_id)->first();

    //     $currentDateTime = Carbon::now();

    //     // Check if the event is ongoing, finished, or not started
    //     $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time);
    //     $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time);

    //     $status = 'ongoing';
    //     if ($currentDateTime->lt($startDateTime)) {
    //         $status = 'not Started'; // Booking is before the event
    //     }

    //     if ($currentDateTime->gt($endDateTime)) {
    //         $status = 'finished'; // Booking is after the event
    //     }

    //     // Find the booking for the logged-in user (assuming one active booking per user)

    //     Organizer::create([
    //         'user_id' => $user->id,
    //         'event_id' => $event->id,
    //         'status' => $status,
    //         'payment_url' => isset($filePath) ? $filePath : "",
    //     ]);

       

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Event booked successfully!',
    //     ], 200);
    // }   

    // public function update(Request $request, Booking $organizer){
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'event_id' => 'required|exists:events,id',
    //     ]);

    //     $event = Event::where('id', $request->event_id)->first();

    //     if($event->price > 0){
    //         $request->validate([
    //             'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         $filePath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');
    //     }

    //     $user = User::where('id', $request->user_id)->first();
    //     $event = Event::where('id', $request->event_id)->first();

    //     $currentDateTime = Carbon::now();

    //     // Check if the event is ongoing, finished, or not started
    //     $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time);
    //     $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time);

    //     $status = 'ongoing';
    //     if ($currentDateTime->lt($startDateTime)) {
    //         $status = 'not Started'; // Booking is before the event
    //     }

    //     if ($currentDateTime->gt($endDateTime)) {
    //         $status = 'finished'; // Booking is after the event
    //     }

    //     // Find the booking for the logged-in user (assuming one active booking per user)

    //     $organizer->update([
    //         'user_id' => $user->id,
    //         'event_id' => $event->id,
    //         'status' => $status,
    //         'payment_url' => isset($filePath) ? $filePath : "",
    //     ]);

       

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Booking updated successfully!',
    //     ], 200);
    // }  

    // public function remove(Organizer $organizer){

    //     $organizer->delete();

    //     return redirect()->back()->with('success', 'Organizer removed successfully.');

    // }
}