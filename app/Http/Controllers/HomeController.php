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
    public function getSuggestedEvents(User $user){
        $total_count = UserTagMapping::where('user_id', $user->id)->sum('count');
        if($total_count == 0){
            return response()->json();
        }

        $userTags = UserTagMapping::where('user_id', $user->id)
        ->get()
        ->map(function ($mapping) use ($total_count) {
            $mapping->weighted_score = ($mapping->avg_score-2.5) * ($mapping->count / $total_count);
            return $mapping;
        })
        ->sortByDesc('weighted_score')->pluck('tag_id');


        $events = EventTagMapping::whereIn('tag_id', $userTags)
            ->distinct('event_id')
            ->pluck('event_id');

        $suggestedEvents = Event::whereIn('id', $events)->with('tags')->get();

        return response()->json($suggestedEvents);
    }


    public function updateUserTagMapping(Request $request){

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'new_score' => 'required',
        ]);

        $eventTagMappings = EventTagMapping::where('event_id', $request->event_id)->get();

        $add_count = 1;
        if($request->new_score < 0){
            $add_count = -1;
        }

        foreach($eventTagMappings as $eventTagMapping){
            $userTagMapping = UserTagMapping::where('user_id', $request->user_id)->where('tag_id', $eventTagMapping->tag_id)->first();
            if(!$userTagMapping){
                UserTagMapping::create([
                    'user_id' => $request->user_id,
                    'tag_id' => $eventTagMapping->tag_id,
                    'avg_score' => $request->new_score,
                    'count' => 1,
                ]);
            }else{
                $userTagMapping->update([
                    'avg_score' => ($userTagMapping->avg_score + $request->new_score)/($userTagMapping->count + 1 ),
                    'count' => $userTagMapping->count + $add_count,
                ]);
            }
        }

        $userTagMappings = UserTagMapping::where('user_id', $request->user_id)->whereIn('tag_id', $eventTagMappings->pluck('tag_id'))->get();
      
        return response()->json($userTagMappings);
    }
}
