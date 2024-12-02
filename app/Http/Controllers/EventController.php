<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getEvents(Request $request)
    {
        if ($request->has('id') && $request->get('id') != null) {
            $events = Event::where('is_shown', 1)->find($request->get('id'));
            return response()->json($events);
        }
        $events = Event::where('is_shown', 1)->with('tags', 'eventCategories')->get();
        return response()->json($events);
    }

    public function getUserBookings($user)
    {
        $bookings = Booking::where('user_id', $user)->get();
        $events = $bookings->map(function ($booking) {
            return Event::find($booking->event_id);
        });
        return response()->json($events);
    }

    public function getUserBookmarks($user)
    {
        $bookmarks = Bookmark::where('user_id', $user)->get();
        $events = $bookmarks->map(function ($bookmark) {
            return Event::find($bookmark->event_id);
        });
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
            if ($bookmark) {
                $bookmark->delete();
                return response()->json(['message' => 'Bookmark removed']);
            }
            else {
                $bookmark = Bookmark::create($request->all());
                return response()->json(['message' => 'Bookmark added']);
            }
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}