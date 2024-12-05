<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $userID = Auth::id();
        $bookings_finished = Booking::where('user_id', $userID)
                            ->where('status', 'finished')
                            ->join('events', 'bookings.event_id', '=', 'events.id')
                            ->orderBy('start_date')
                            ->paginate(6, ['*'], 'finished_page');
        $bookings_ongoing = Booking::where('user_id', $userID)
                            ->where('status', 'ongoing')
                            ->join('events', 'bookings.event_id', '=', 'events.id')
                            ->orderBy('start_date')
                            ->paginate(6, ['*'], 'ongoing_page');
        $bookings_not_started = Booking::where('user_id', $userID)
                            ->where('status', 'not started')
                            ->orderBy('event_id')
                            ->paginate(6, ['*'], 'not_started_page');
        $bookings = [
            // 'Your Not Started Events' => $bookings_not_started,
            'Your Ongoing Events' => $bookings_ongoing,
            'Your Finished Events' => $bookings_finished
        ];   
        return view('user.history', compact('bookings'));
    }
}
