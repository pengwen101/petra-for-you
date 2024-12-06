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
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventCategoryController;

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
    Route::get('/history/review/{id}/edit', [ReviewController::class, 'edit'])->name('editReview');
    Route::post('/history/review/{id}/update', [ReviewController::class, 'update'])->name('updateReview');
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
Route::middleware(['organizer'])->prefix('organizer')->as('organizer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('organizer.dashboard');
    })->name('dashboard');
    Route::get('/events', [OrganizerController::class, 'showEvents'])->name('events');
    Route::get('/bookings', function () {
        return view('organizer.bookings');
    })->name('bookings');
    Route::get('/logout', [OrganizerController::class, 'logout'])->name('logout');
    Route::post('/events', [EventController::class, 'addEvent'])->name('addEvent');
    Route::delete('/events', [EventController::class, 'deleteEvent'])->name('deleteEvent');
    Route::post('/events/toggle/{event}', [EventController::class, 'toggleEvent'])->name('toggleEvent');
});

Route::middleware('admin.guest')->group(function () {
    Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login']);
});
Route::middleware('admin')->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('myAdmin.dashboard');
    })->name('dashboard');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'remove'])->name('user.remove');


    // Event
    Route::get('/event', [EventController::class, 'index'])->name('event');
    Route::delete('/event/{event}', [EventController::class, 'remove'])->name('event.remove');

    // Tag
    Route::get('/tag', [TagController::class, 'index'])->name('tag');
    Route::post('/tag', [TagController::class, 'add'])->name('tag.add');
    Route::put('/tag/{tag}', [TagController::class, 'update'])->name('tag.update');
    Route::delete('/tag/{tag}', [TagController::class, 'remove'])->name('tag.remove');

    // Category
    Route::get('/category', [EventCategoryController::class, 'index'])->name('category');
    Route::post('/category', [EventCategoryController::class, 'add'])->name('category.add');
    Route::put('/category/{category}', [EventCategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [EventCategoryController::class, 'remove'])->name('category.remove');

    // Booking
    Route::get('/booking', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking', [BookingController::class, 'add'])->name('booking.add');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'remove'])->name('booking.remove');

    // Organizer
    Route::get('/organizer', [OrganizerController::class, 'index'])->name('organizer');
    Route::post('/organizer', [OrganizerController::class, 'add'])->name('organizer.add');
    Route::put('/organizer/{organizer}', [OrganizerController::class, 'update'])->name('organizer.update');
    Route::delete('/organizer/{organizer}', [OrganizerController::class, 'remove'])->name('organizer.remove');

    // Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin', [AdminController::class, 'add'])->name('admin.add');
    Route::put('/admin/{admin}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{admin}', [AdminController::class, 'remove'])->name('admin.remove');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/detail/{event}', [EventController::class, 'show'])->name('event.show');

Route::middleware('auth')->group(function () {
    Route::get('/booking/show/{event}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/store/{event}', [BookingController::class, 'store'])->name('booking.store');
});


require __DIR__ . '/auth.php';

