<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(Request $request)
{
    $booking = Booking::create([
        'customer_id' => auth()->id,
        'type' => $request->type,
        'status' => 'pending',
    ]);

    // 📩 EMAIL DI SINI (SETELAH CREATE)
    Mail::raw(
        "Booking baru masuk ID: ".$booking->id,
        function ($msg) {
            $msg->to('admin@travel.com')
                ->subject('Booking Baru');
        }
    );

    return response()->json($booking);
}
}