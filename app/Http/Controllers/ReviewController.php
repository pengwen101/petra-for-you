<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\UserTagMapping;
use App\Models\EventTagMapping;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class ReviewController extends Controller
{
    public function index($event_id)
    {
        $booking = Booking::where('event_id', $event_id)
            ->first();
        $reviews = Booking::where('event_id', $event_id)
            ->get();
        $averageStars = $reviews->avg('stars');
     
        return view('user.review.index', compact('reviews', 'booking', 'averageStars'));
    }

    public function create($id)
    {
        $booking = Booking::find($id);
        return view('user.review.create', compact('booking'));
    }

    public function unsuggest(Collection $eventTagMappings, int $user_id, array $score)
    {
        $i = 0;
        foreach ($eventTagMappings as $eventTagMapping) {
            $userTagMapping = UserTagMapping::where('user_id', $user_id)->where('tag_id', $eventTagMapping->tag_id)->first();
            if (isset($userTagMapping)) {
                if ($userTagMapping->score - $score[$i] <= 0) {
                    $userTagMapping->delete();
                } else {
                    $userTagMapping->update([
                        'score' => $userTagMapping->score - $score[$i],
                    ]);
                }
            }
            $i++;
        }
    }

    public function suggest(Collection $eventTagMappings, int $user_id, array $score)
    {
        $i = 0;
        foreach ($eventTagMappings as $eventTagMapping) {
            $userTagMapping = UserTagMapping::where('user_id', $user_id)->where('tag_id', $eventTagMapping->tag_id)->first();
            if (!$userTagMapping) {
                UserTagMapping::create([
                    'user_id' => $user_id,
                    'tag_id' => $eventTagMapping->tag_id,
                    'score' => $score[$i],
                ]);
            } else {
                $userTagMapping->update([
                    'score' => $userTagMapping->score + $score[$i],
                ]);
            }
            $i++;
        }
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

        $booking = Booking::query()->where('id', $request->booking_id)->first();
        
        $booking->update([
            'review' => $request->review,
            'stars' => $request->stars,
            'updated_at' => now()
        ]);

        if($request->stars >=3){
            
            $eventTagMappings = EventTagMapping::where('event_id', $booking->event->id)->get();
            $scores = [];
            foreach($eventTagMappings as $eventTagMapping){
                $scores[] = ($eventTagMapping->score * $request->stars-2);
            }

            $this->suggest($eventTagMappings, $booking->user->id, $scores);
        }

        if($request->stars <3){
            
            $eventTagMappings = EventTagMapping::where('event_id', $booking->event->id)->get();
            $scores = [];
            foreach($eventTagMappings as $eventTagMapping){
                $scores[] = ($eventTagMapping->score * $request->stars-3);
            }

            $this->unsuggest($eventTagMappings, $booking->user->id, $scores);
        }

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

        $booking = Booking::query()->where('id', $id)->first();
        
        $booking->update([
            'review' => $request->review,
            'stars' => $request->stars,
            'updated_at' => now()
        ]);


        if($request->stars >=3){
            $eventTagMappings = EventTagMapping::where('event_id', $booking->event->id)->get();
            $scores = [];
            foreach($eventTagMappings as $eventTagMapping){
                $scores[] = ($eventTagMapping->score * $request->stars-2);
            }
            
            $this->suggest($eventTagMappings, $booking->user->id, $scores);
        }

        if($request->stars <3){
            
            $eventTagMappings = EventTagMapping::where('event_id', $booking->event->id)->get();
            $scores = [];
            foreach($eventTagMappings as $eventTagMapping){
                $scores[] = ($eventTagMapping->score * $request->stars-3);
            }

            $this->unsuggest($eventTagMappings, $booking->user->id, $scores);
        }

        FacadesSession::flash('message', 'Review updated successfully!');
        FacadesSession::flash('alert-class', 'success');
        return redirect()->route('user.history');
    }
}
