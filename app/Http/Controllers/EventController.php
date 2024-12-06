<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Models\UserTagMapping;
use App\Models\EventTagMapping;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('detail.detailEvent', compact('event'));
    }

    public function getEvents(Request $request)
    {
        if ($request->has('id') && $request->get('id') != null) {
            $events = Event::where('is_shown', 1)->with('tags', 'eventCategories')->find($request->get('id'));
            return response()->json($events);
        }
        $events = Event::where('is_shown', 1)->with('tags', 'eventCategories')->get();
        return response()->json($events);
    }

    public function getUserBookings($user)
    {
        // Get all event IDs from the bookings for the given user
        $eventIds = Booking::where('user_id', $user)->pluck('event_id');

        // Fetch all events with the collected event IDs and load their tags and eventCategories
        $events = Event::with('tags', 'eventCategories')
            ->whereIn('id', $eventIds)
            ->get();

        return response()->json($events);
    }

    public function getUserBookmarks($user)
    {
        // $bookmarks = Bookmark::where('user_id', $user)->get();
        // $events = $bookmarks->map(function ($bookmark) {
        //     return Event::with('tags', 'eventCategories')->whereIn('id', $bookmark->event_id)->get();
        // });
        // return response()->json($events);
        // Get all event IDs from the bookmarks for the given user
        $eventIds = Bookmark::where('user_id', $user)->pluck('event_id');

        // Fetch all events with the collected event IDs and load their tags and eventCategories
        $events = Event::with('tags', 'eventCategories')
            ->whereIn('id', $eventIds)
            ->get();

        return response()->json($events);
    }

    public function getEventTagsOrCategory($event, Request $request)
    {
        $event = Event::find($event);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        if ($request->has('tags')) {
            return response()->json($event->tags->pluck('name'));
        } elseif ($request->has('category')) {
            return response()->json($event->eventCategories->pluck('name'));
        }

        return response()->json(['error' => 'Invalid query parameter'], 400);
    }

    public function filterEvents(Request $request)
    {
        $events = Event::where('is_shown', 1);

        if ($request->has('category')) {
            $events = $events->whereHas('eventCategories', function ($query) use ($request) {
                $query->where('event_category_id', $request->get('category'));
            });
        }

        if ($request->has('tags')) {
            $events = $events->whereHas('tags', function ($query) use ($request) {
                $query->where('tag_id', $request->get('tags'));
            });
        }

        return response()->json($events->get());
    }

    public function unsuggest(Collection $eventTagMappings, int $user_id, int $score)
    {
        foreach ($eventTagMappings as $eventTagMapping) {
            $userTagMapping = UserTagMapping::where('user_id', $user_id)->where('tag_id', $eventTagMapping->tag_id)->first();
            if (isset($userTagMapping)) {
                if ($userTagMapping->score - $score <= 0) {
                    $userTagMapping->delete();
                } else {
                    $userTagMapping->update([
                        'score' => $userTagMapping->score - $score,
                    ]);
                }
            }
        }
    }

    public function suggest(Collection $eventTagMappings, int $user_id, int $score)
    {
        foreach ($eventTagMappings as $eventTagMapping) {
            $userTagMapping = UserTagMapping::where('user_id', $user_id)->where('tag_id', $eventTagMapping->tag_id)->first();
            if (!$userTagMapping) {
                UserTagMapping::create([
                    'user_id' => $user_id,
                    'tag_id' => $eventTagMapping->tag_id,
                    'score' => $score,
                ]);
            } else {
                $userTagMapping->update([
                    'score' => $userTagMapping->score + $score,
                ]);
            }
        }
    }

    public function addBookmark(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);
        try {
            // search bookmark and delete if found
            $bookmark = Bookmark::where('user_id', $request->get('user_id'))
                ->where('event_id', $request->get('event_id'))
                ->first();

            $eventTagMappings = EventTagMapping::where('event_id', $request->event_id)->get();

            if ($bookmark) {
                $this->unsuggest($eventTagMappings, $request->user_id, 1);
                $bookmark->delete();

                return response()->json(['message' => 'Bookmark removed']);
            } else {

                $bookmark = Bookmark::create($request->all());
                $this->suggest($eventTagMappings, $request->user_id, 1);

                return response()->json(['message' => 'Bookmark added']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addEvent(Request $request)
    {

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'venue' => 'required|string|max:255',
                'max_register_date' => 'required|date',
                'start_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:max_register_date',
                'end_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_datetime',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'organizer_id' => 'required|exists:organizers,id',
                'event_category_id.*' => 'required|exists:event_categories,id',
                'event_category_id' => 'required|array',
                'tag_id' => 'required|array',
                'tag_id.*' => 'exists:tags,id'
            ]);
            // split start_datetime and end_datetime into date and time
            $request->merge([
                'start_date' => date('Y-m-d', strtotime($request->start_datetime)),
                'start_time' => date('H:i:s', strtotime($request->start_datetime)),
                'end_date' => date('Y-m-d', strtotime($request->end_datetime)),
                'end_time' => date('H:i:s', strtotime($request->end_datetime)),
            ]);

            $event = Event::create($request->all());
            // insert into event tag mapping
            $event->tags()->attach($request->tag_id);

            // insert into event category mapping
            $event->eventCategories()->attach($request->event_category_id);

            return redirect()->route('organizer.events')->with('success', 'Event added');
        } 
        // catch (\Illuminate\Validation\ValidationException $e) {
        //     // Debug validation errors
        //     dd($e->errors());
        // } 
        catch (\Exception $e) {
            return redirect()->route('organizer.events')->with('error', $e->getMessage());
        }
    }

    public function toggleEvent(Event $event)
    {
        $event->is_shown = !$event->is_shown;
        $event->save();
        return redirect()->route('organizer.events');

    }

    public function deleteEvent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:events,id'
        ]);

        try {
            $event = Event::find($request->id);
            $event->delete();
            return redirect()->route('organizer.events')->with('success', 'Event deleted');
        } catch (\Exception $e) {
            return redirect()->route('organizer.events')->with('error', $e->getMessage());
        }
    }

    public function updateEvent(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:events,id',
                'title' => 'required|string|max:255',
                'venue' => 'required|string|max:255',
                'max_register_date' => 'required|date',
                'start_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:max_register_date',
                'end_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_datetime',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'organizer_id' => 'required|exists:organizers,id',
                'event_category_id.*' => 'required|exists:event_categories,id',
                'event_category_id' => 'required|array',
                'tag_id' => 'required|array',
                'tag_id.*' => 'exists:tags,id'
            ]);
            // split start_datetime and end_datetime into date and time
            $request->merge([
                'start_date' => date('Y-m-d', strtotime($request->start_datetime)),
                'start_time' => date('H:i:s', strtotime($request->start_datetime)),
                'end_date' => date('Y-m-d', strtotime($request->end_datetime)),
                'end_time' => date('H:i:s', strtotime($request->end_datetime)),
            ]);


            $event = Event::find($request->id);
            $event->update($request->all());

            // insert into event tag mapping
            $event->tags()->sync($request->tag_id);

            // insert into event category mapping
            $event->eventCategories()->sync($request->event_category_id);
            return redirect()->route('organizer.events')->with('success', 'Event updated');
        
        } 
        // catch (\Illuminate\Validation\ValidationException $e) {
        //     // Debug validation errors
        //     dd($e->errors()); 
        // }
        catch (\Exception $e) {
            return redirect()->route('organizer.events')->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        $events = Event::all()->sortByDesc('created_at');
        return view('myAdmin.event.event', compact('events'));
    }

    public function remove($id)
    {
        $event = Event::findOrFail($id);

        try {
            $event->update(['is_shown' => false]);

            return redirect()->route('admin.event')->with('success', 'Event successfully hidden');
        } catch (\Exception $e) {
            return redirect()->route('admin.event')->with('error', 'Failed to remove the event');
        }
    }
}
