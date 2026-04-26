<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    public function index()
    {
        return view('admin.offers');
    }
}