<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('detail.detailEvent', compact('event'));
    }
}
