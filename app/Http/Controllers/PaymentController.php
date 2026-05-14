<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Driver;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function check(Request $request)
    {
        $bookings = collect();

        if (
            $request->filled('booking_code') &&
            $request->filled('phone_number')
        ) {

            $bookings = Booking::with('payment')

                ->where(
                    'booking_code',
                    $request->booking_code
                )

                ->where(
                    'phone_number',
                    $request->phone_number
                )

                ->latest()

                ->get();
        }

        return view(
            'customer.payment',
            compact('bookings')
        );
    }

    public function upload(Request $request, $id)
    {
        $request->validate([

            'payment_method' =>
            'required|in:qris,cash',
        ]);

        $booking = Booking::with('payment')
            ->findOrFail($id);

        if (
            $booking->payment &&
            !in_array(
                $booking->payment->status,
                ['rejected']
            )
        ) {

            return back()->with(
                'error',
                'Pembayaran sudah diproses'
            );
        }

        if (
            $booking->payment &&
            $booking->payment->status === 'rejected'
        ) {

            $booking->payment->delete();
        }

        $proof = null;

        if ($request->payment_method === 'qris') {

            $request->validate([

                'payment_proof' =>
                'required|image|max:5120',
            ]);

            $proof = $request
                ->file('payment_proof')
                ->store(
                    'payment-proofs',
                    'public'
                );

            $paymentStatus =
                'waiting_verification';
        } else {

            $paymentStatus =
                'waiting_driver_collection';
        }

        Payment::create([

            'booking_id' =>
            $booking->id,

            'payment_method' =>
            $request->payment_method,

            'amount' =>
            $booking->total_price,

            'payment_proof' =>
            $proof,

            'paid_at' =>
            now(),

            'status' =>
            $paymentStatus,
        ]);

        $booking->update([

            'status' => 'pending',
        ]);

        WhatsappService::send(

            $booking->phone_number,

            "💳 PEMBAYARAN BERHASIL

Kode:
{$booking->booking_code}

Metode:
" . strtoupper($request->payment_method) . "

Status:
{$paymentStatus}

Sanu Travel 🚐"
        );

        return redirect()

            ->route('payment.check', [

                'booking_code' =>
                $booking->booking_code,

                'phone_number' =>
                $booking->phone_number,
            ])

            ->with(
                'success',
                'Pembayaran berhasil dikirim'
            );
    }

    public function verify($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([

            'status' =>
            'verified',

            'verified_at' =>
            now(),
        ]);

        $booking = $payment->booking;

        $booking->update([

            'status' =>
            'confirmed',
        ]);

        $pdf = Pdf::loadView(
            'pdf.payment-receipt',
            compact('booking', 'payment')
        );

        Mail::send(

            'emails.payment-verified',

            compact('booking', 'payment'),

            function ($message)
            use ($booking, $pdf) {

                $message

                    ->to($booking->email)

                    ->subject(
                        'Pembayaran Berhasil Diverifikasi'
                    )

                    ->attachData(
                        $pdf->output(),
                        'payment-receipt.pdf'
                    );
            }
        );

        WhatsappService::send(

            $booking->phone_number,

            "✅ PEMBAYARAN VERIFIED

Kode:
{$booking->booking_code}

Status:
VERIFIED

Terima kasih 🚐"
        );

        return back()->with(
            'success',
            'Pembayaran berhasil diverifikasi'
        );
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([

            'status' => 'rejected',
        ]);

        WhatsappService::send(

            $payment->booking->phone_number,

            "❌ PEMBAYARAN DITOLAK

Kode:
{$payment->booking->booking_code}

Silakan upload ulang bukti pembayaran."
        );

        return back()->with(
            'error',
            'Pembayaran ditolak'
        );
    }

    public function driverCashPage()
    {
        $user = Auth::user();

        $driver = Driver::where('email', $user->email)->first();

        $payments = Payment::with('booking')
            ->where('status', 'waiting_driver_collection')
            ->whereHas('booking', function ($q) use ($driver) {

                $q->whereHas('deliveryOrder', function ($dq) use ($driver) {

                    $dq->where('driver_id', $driver->id);
                });
            })
            ->latest()
            ->get();
        return view(
            'driver.payments',
            compact('payments')
        );
    }

    public function receiveCash(Request $request, $id)
    {
        $request->validate([

            'driver_proof' =>
            'required|image|max:5120',
        ]);

        $payment = Payment::findOrFail($id);
        $proof = $request
            ->file('driver_proof')
            ->store(
                'driver-proofs',
                'public'
            );

        $payment->update([

            'status' =>
            'cash_received',
            'driver_received_cash' => true,
            'driver_received_at' => now(),
            'driver_proof' =>
            $proof,
        ]);

        return back()->with(
            'success',
            'Cash Berhasil diterima'
        );
    }

    public function settle($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([

            'status' =>
            'settled',

            'settled_to_admin_at' =>
            now(),
        ]);

        return back()->with(
            'success',
            'Uang berhasil disettle'
        );
    }
}
