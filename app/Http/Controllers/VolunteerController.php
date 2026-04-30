<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        return view('pages.volunteer-dashboard');
    }
}
