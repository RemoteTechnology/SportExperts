<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        return view('tournament.index');
    }
    public function history()
    {
        return view('tournament.history');
    }
}
