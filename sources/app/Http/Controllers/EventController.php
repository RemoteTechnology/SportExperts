<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('event.index');
    }

    public function history()
    {
        return view('event.history');
    }
}
