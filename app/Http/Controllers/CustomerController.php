<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $totalBooking = Booking::where('user_id', $user->id)->count();

        $lastBooking = Booking::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('customer.dashboard', compact('user', 'totalBooking', 'lastBooking'));
    }
}