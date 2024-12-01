<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\UserTagMapping;
use App\Models\EventTagMapping;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $nrp = 'c14220160';
        $user = User::where('nrp', $nrp)->with('tags')->first();
        if(!$user){
            return view('home', ['all_events' => collect(), 'suggested_events' => collect()]);
        }

        $all_events = Event::query()->with('tags')->get();

        $userTags = UserTagMapping::where('user_id', $user->id)
            ->where('avg_score', '>=', 3)
            ->pluck('tag_id');

        $events = EventTagMapping::whereIn('tag_id', $userTags)
            ->distinct('event_id')
            ->pluck('event_id');

        $suggested_events = Event::whereIn('id', $events)->with('tags')->get();

        return view('home', ['all_events'=>$all_events, 'suggested_events'=>$suggested_events]);
    }
}
