<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\Booking;
use App\Models\Bookmark;

Route::get('/', function () {
    return redirect()->route('user.dashboard');
});

Route::middleware(['auth', 'verified'])->prefix('user')->as('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
    Route::get('/events', function () {
        return view('user.events');
    })->name('events');
    Route::get('/history', function () {
        return view('user.history');
    })->name('history');
    
});

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    //return all events that are active
    Route::get('/events', function () {
        $events = Event::where('is_shown', 1)->get();
        return response()->json($events);
    })->name('events');
    // return a single event base on the id
    Route::get('/events/{event}', function ($event) {
        $event = Event::where('is_shown', 1)->find($event);
        return response()->json($event);
    })->name('events.show');
    // return all event base on the user id
    Route::get('/events/user/{user}', function ($user) {
        $bookings = Booking::where('user_id', $user)->get();
        $events = $bookings->map(function ($booking) {
            return Event::find($booking->event_id);
        });
        return response()->json($events);
    })->name('events.user'); 
    // return all bookmarks base on the user id
    Route::get('/bookmarks/user/{user}', function ($user) {
        $bookmarks = Bookmark::where('user_id', $user)->get();
        $events = $bookmarks->map(function ($bookmark) {
            return Event::find($bookmark->event_id);
        });
        return response()->json($events);
    })->name('bookmarks.user');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
