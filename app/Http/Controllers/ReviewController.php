<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

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

    public function create($id)
    {
        $booking = Booking::find($id);
        return view('user.review.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'review' => 'required|max:255',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        if (!$validatedData) {
            FacadesSession::flash('message', 'Review failed!');
            FacadesSession::flash('alert-class', 'failed');
            return redirect()->route('user.history');
        }

        Booking::query()->where('id', $request->booking_id)->update([
            'review' => $request->review,
            'stars' => $request->stars,
            'updated_at' => now()
        ]);

        FacadesSession::flash('message', 'Review submitted successfully!');
        FacadesSession::flash('alert-class', 'success');
        return redirect()->route('user.history');
    }

    public function edit($id)
    {
        $booking = Booking::find($id);
        return view('user.review.edit', compact('booking'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'review' => 'required|max:255',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        if (!$validatedData) {
            FacadesSession::flash('message', 'Review update failed!');
            FacadesSession::flash('alert-class', 'failed');
            return redirect()->route('user.history');
        }

        Booking::query()->where('id', $id)->update([
            'review' => $request->review,
            'stars' => $request->stars,
            'updated_at' => now()
        ]);

        FacadesSession::flash('message', 'Review updated successfully!');
        FacadesSession::flash('alert-class', 'success');
        return redirect()->route('user.history');
    }
}
