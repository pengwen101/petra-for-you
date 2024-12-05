<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HistoryController extends Controller
{
    public function index()
    {
        $userID = Auth::id();
        $bookings = User::find($userID)->bookings->where('status', 'finished')->sortBy('event_id');
        return view('user.history', compact('bookings'));
    }
}
