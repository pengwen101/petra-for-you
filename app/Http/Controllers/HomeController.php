<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\UserTagMapping;
use App\Models\EventTagMapping;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(){
        $todayDate = Carbon::today();
        $user = Auth::user();

        $startOfMonth = $todayDate->startOfMonth();
        $endOfMonth = $todayDate->endOfMonth();

        $eventsThisMonth = Event::whereBetween('start_date', [$startOfMonth, $endOfMonth])
        ->where('start_date', '>=', $todayDate)
        ->get();

        $userTags = UserTagMapping::where('user_id', $user->id)
        ->get()
        ->sortByDesc('score')->pluck('tag_id');

        $events = EventTagMapping::whereIn('tag_id', $userTags)
            ->distinct('event_id')
            ->pluck('event_id');

        $suggestedEvents = Event::whereIn('id', $events)->with('tags')->get();

        $tags = Tag::whereIn('id', $userTags)->pluck('name');

        return view('user.dashboard', ['tags' => $tags, 'eventsThisMonth' => $eventsThisMonth, 'suggestedEvents' =>$suggestedEvents]);
        
    }
    public function getSuggestedEvents(User $user){
        $userTags = UserTagMapping::where('user_id', $user->id)
        ->get()
        ->sortByDesc('score')->pluck('tag_id');

        $events = EventTagMapping::whereIn('tag_id', $userTags)
            ->distinct('event_id')
            ->pluck('event_id');

        $suggestedEvents = Event::whereIn('id', $events)->with('tags')->get();

        return response()->json($suggestedEvents);
    }
}
