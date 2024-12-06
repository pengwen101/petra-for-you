<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('organizer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('organizer.login');
    }
    
    public function showLoginForm()
    {
        return view('organizer.login');
    }

    public function login(Request $request){
         // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');


        if (Auth::guard('organizer')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('organizer.events')->with('success', 'Login successful');
        }
        return back()->with('error', 'Invalid email or password');
    }

    public function showEvents () {
        $id = Auth::guard('organizer')->user()->id;
        $events = Event::where('organizer_id', $id)->get();
        $categories = EventCategory::all();
        $tags = Tag::all();
        return view('organizer.events', compact('events', 'categories', 'tags'));
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}