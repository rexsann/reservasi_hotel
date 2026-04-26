<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FacilityController extends Controller
{
    public function index()
    {
        return view('admin.facility');
    }
}