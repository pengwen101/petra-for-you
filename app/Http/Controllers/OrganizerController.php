<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    //
    public function showLoginForm(){
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
            return redirect()->route('organizer.dashboard')->with('success', 'Login successful');
        }
        return back()->with('error' , 'Invalid email or password');
    }
}
