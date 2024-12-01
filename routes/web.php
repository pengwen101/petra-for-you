<?php

use App\Models\Event;
use App\Models\Booking;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;

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
    // return all events that are active or 
    // single event base on the id (use query parameter id) or 
    // all events base on user_id (use query parameter user_id)
    Route::get('/events', [EventController::class, 'getEvents'])->name('events');
    
    // return all event base on the user id
    Route::get('/events/bookings/{user}', [EventController::class, 'getUserBookings']);

    //return tags or category of an event
    Route::get('/events/{event}/filter', [EventController::class, 'getEventTagsOrCategory']);
    
    // return all bookmarks base on the user id
    Route::get('/events/bookmarks/{user}', [EventController::class, 'getUserBookmarks']);
    
    // filter event base on category and tags
    Route::get('/events/filter', [EventController::class, 'filterEvents']);


})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
