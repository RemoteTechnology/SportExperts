<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('event.index');
    }

    public function create()
    {
        return view('event.create');
    }

    public function detail()
    {
        return view('event.detail');
    }

    public function update()
    {
        return view('event.create');
    }

    public function history()
    {
        return view('event.history');
    }
}
