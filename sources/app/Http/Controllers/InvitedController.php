<?php

namespace App\Http\Controllers;

class InvitedController extends Controller
{
    public function index()
    {
        return view('invites.index');
    }

    public function detail()
    {
        return view('invites.detail');
    }
}
