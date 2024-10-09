<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        return view('participant.index');
    }

    public function search()
    {
        return view('participant.search');
    }
}
