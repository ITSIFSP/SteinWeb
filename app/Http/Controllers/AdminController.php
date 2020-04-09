<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        return view('user.login');
    }

    public function guest()
    {
        return view('map.guest');
    }
}
