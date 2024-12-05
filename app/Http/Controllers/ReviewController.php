<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($event_id)
    {
        $event = Booking::where('event_id', $event_id)
            ->first();
        $reviews = Booking::where('event_id', $event_id)
            ->get();
        $averageStars = $reviews->avg('stars');
        return view('user.review.index', compact('reviews', 'event', 'averageStars'));
    }
}
