<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryController;
use App\Models\Event;
use App\Models\Booking;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('user.dashboard');
});

Route::middleware(['auth', 'verified'])->prefix('user')->as('user.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/events', function () {
        return view('user.events');
    })->name('events');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/history/review/{id}', [ReviewController::class, 'index'])->name('review');
});

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::group(['prefix' => 'events', 'as' => 'events.'], function () {
        // return all events that are active or
        // single event base on the id (use query parameter id) or
        Route::get('/', [EventController::class, 'getEvents'])->name('get');

        //return suggested events to user
        Route::get('/suggested/{user}', [HomeController::class, 'getSuggestedEvents'])->name("suggestedEvents");

        //update user tag mapping
        Route::put('/suggested/update', [HomeController::class, 'updateUserTagMapping'])->name('updateUserTagMapping');

        // return all event base on the user id
        Route::get('bookings/{user}', [EventController::class, 'getUserBookings'])->name('bookings');

        // return all bookmarks base on the user id
        Route::get('bookmarks/{user}', [EventController::class, 'getUserBookmarks'])->name('bookmarks');

        // add event to bookmark
        Route::post('bookmarks', [EventController::class, 'addBookmark'])->name('addBookmark');

        //return tags or category of an event
        Route::get('{event}/filter', [EventController::class, 'getEventTagsOrCategory'])->name('getTagsOrCategory');

        // filter event base on category and tags
        Route::get('filter', [EventController::class, 'filterEvents'])->name('filter');
    });


})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('organizer.guest')->group(function () {
    Route::get('/organizer/login', [OrganizerController::class, 'showLoginForm'])->name('organizer.login');
    Route::post('organizer/login', [OrganizerController::class, 'login']);    
});
Route::middleware(['auth:organizer', 'organizer'])->prefix('organizer')->as('organizer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('organizer.dashboard');
    })->name('dashboard');
    Route::get('/events', [OrganizerController::class, 'showEvents'])->name('events');
    Route::get('/bookings', function () {
        return view('organizer.bookings');
    })->name('bookings');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
});

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login']);
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('myAdmin.dashboard');
    })->name('dashboard');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/detail/{event}', [EventController::class, 'show'])->name('event.show');

Route::middleware('auth')->group(function () {
    Route::get('/booking/show/{event}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/store/{event}', [BookingController::class, 'store'])->name('booking.store');
});


require __DIR__ . '/auth.php';

