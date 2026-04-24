<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required',
            'method' => 'required|in:cash,transfer',
            'amount' => 'required',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // =========================
        // CASH PAYMENT
        // =========================
        if ($request->method == 'cash') {

            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $request->amount,
                'method' => 'cash',
                'status' => 'verified',
            ]);

            $booking->update(['status' => 'confirmed']);

            // 📩 EMAIL CUSTOMER (AMAN)
            if ($booking->customer) {
                Mail::raw(
                    "Pembayaran cash kamu berhasil. Booking ID: ".$booking->id,
                    function ($msg) use ($booking) {
                        $msg->to($booking->customer->email)
                            ->subject('Payment Success');
                    }
                );
            }

            // 📩 EMAIL ADMIN
            $admins = User::where('role', 'admin')->pluck('email');

            foreach ($admins as $email) {
                Mail::raw(
                    "Payment cash masuk untuk Booking ID: ".$booking->id,
                    function ($msg) use ($email) {
                        $msg->to($email)
                            ->subject('Payment Cash Masuk');
                    }
                );
            }

            return response()->json([
                'message' => 'Cash payment berhasil & auto verified',
                'payment' => $payment
            ]);
        }

        // =========================
        // TRANSFER PAYMENT
        // =========================
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $request->amount,
            'method' => 'transfer',
            'status' => 'pending',
        ]);

        // 📩 EMAIL CUSTOMER (AMAN)
        if ($booking->customer) {
            Mail::raw(
                "Silakan transfer untuk Booking ID: ".$booking->id." lalu upload bukti.",
                function ($msg) use ($booking) {
                    $msg->to($booking->customer->email)
                        ->subject('Instruksi Pembayaran');
                }
            );
        }

        return response()->json([
            'message' => 'Silakan transfer & upload bukti',
            'payment' => $payment
        ]);
    }
}