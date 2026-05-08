<?php

namespace App\Http\Controllers;

use App\Models\Service;

class LandingController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('price')->get();

        return view('welcome', compact('services'));
    }
}