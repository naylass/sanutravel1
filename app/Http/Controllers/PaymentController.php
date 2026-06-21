<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Income;
use App\Services\WhatsappService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentToAdmin;
use App\Mail\PaymentUploadedMail;
use App\Mail\DriverCashReceivedAdminMail;
use App\Mail\DriverCashReceivedCustomerMail;
use App\Mail\PaymentSettledMail;
use App\Mail\PaymentVerifiedMail;
use App\Mail\DriverAssignedCashMail;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function check(Request $request)
    {
        $bookings = collect();

        if (
            $request->filled('booking_code') &&
            $request->filled('phone_number')
        ) {

            $bookings = Booking::with([
                'payment',
                'deliveryOrder.driver'
            ])

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
            'required|in:qris,cash,transfer',
        ]);

        $booking = Booking::with([
            'payment',
            'deliveryOrder.driver'
        ])->findOrFail($id);

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

        if (
            in_array(
                $request->payment_method,
                ['qris', 'transfer']
            )
        ) {

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

        $payment = Payment::create([

            'booking_id' =>
            $booking->id,

            'payment_method' =>
            $request->payment_method,

            'amount' =>
            $booking->total_price,

            'payment_proof' =>
            $proof,

            'paid_at' =>
            now('Asia/Jakarta'),

            'status' =>
            $paymentStatus,
        ]);

        $booking->update([

            'status' => 'pending',
        ]);
        $booking->update([

            'status' => 'pending',
        ]);

        if ($request->payment_method === 'cash') {

            $deliveryOrder = $booking->deliveryOrder;

            if (
                $deliveryOrder &&
                $deliveryOrder->driver
            ) {

                $driver = $deliveryOrder->driver;

                try {

                    if (!empty($driver->email)) {

                        Mail::to($driver->email)
                            ->send(
                                new DriverAssignedCashMail($booking)
                            );
                    }
                } catch (\Exception $e) {

                    logger(
                        'EMAIL DRIVER ASSIGNED ERROR: ' .
                            $e->getMessage()
                    );
                }
            }
        }

        try {

            Mail::to('nylaadjah@gmail.com')
                ->send(new PaymentToAdmin($payment));

            if (!empty($booking->email)) {

                Mail::to($booking->email)
                    ->send(new PaymentUploadedMail($payment));
            }
        } catch (\Exception $e) {

            logger(
                'EMAIL PAYMENT ERROR: ' .
                    $e->getMessage()
            );
        }
        WhatsappService::send(

            $booking->phone_number,

            "💳 PEMBAYARAN BERHASIL

            Kode Booking:
            {$booking->booking_code}

            Metode:
            " . strtoupper($request->payment_method) . "

            Status:
            {$paymentStatus}

            Terima kasih telah melakukan pembayaran 🚐"
        );

        WhatsappService::send(

            '6287764868369',

            "📥 PEMBAYARAN MASUK

            Customer:
            {$booking->customer_name}

            Kode:
            {$booking->booking_code}

            Metode:
            " . strtoupper($request->payment_method)
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
        $payment = Payment::with('booking')->findOrFail($id);

        PaymentService::verify($payment);

        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }

    public function reject($id)
{
    $payment = Payment::with('booking')->findOrFail($id);

    PaymentService::reject($payment);

    return back()->with('error', 'Pembayaran berhasil ditolak');
}

    public function driverCashPage()
    {
        $user = Auth::user();

        $driver = Driver::where(
            'email',
            $user->email
        )->first();

        $payments = Payment::with('booking')

            ->where(
                'status',
                'waiting_driver_collection'
            )

            ->whereHas(
                'booking',
                function ($q)
                use ($driver) {

                    $q->whereHas(
                        'deliveryOrder',
                        function ($dq)
                        use ($driver) {

                            $dq->where(
                                'driver_id',
                                $driver->id
                            );
                        }
                    );
                }
            )

            ->latest()

            ->get();

        return view(
            'driver.payments',
            compact('payments')
        );
    }

    public function receiveCash(
        Request $request,
        $id
    ) {

        $request->validate([

            'driver_proof' =>
            'required|image|max:5120',
        ]);

        $payment = Payment::with('booking')
            ->findOrFail($id);

        $booking = $payment->booking;

        $proof = $request
            ->file('driver_proof')
            ->store(
                'driver-proofs',
                'public'
            );

        $payment->update([

            'status' =>
            'cash_received',

            'driver_received_cash' =>
            true,

            'driver_received_at' =>
            now('Asia/Jakarta'),

            'driver_proof' =>
            $proof,
        ]);


        try {

            Mail::to(
                'nylaadjah@gmail.com'
            )->send(
                new DriverCashReceivedAdminMail($payment)
            );
        } catch (\Exception $e) {

            logger(
                'EMAIL ADMIN CASH ERROR: ' .
                    $e->getMessage()
            );
        }

        try {

            if (!empty($booking->email)) {

                Mail::to(
                    $booking->email
                )->send(
                    new DriverCashReceivedCustomerMail($payment)
                );
            }
        } catch (\Exception $e) {

            logger(
                'EMAIL CUSTOMER CASH ERROR: ' .
                    $e->getMessage()
            );
        }


        try {

            WhatsappService::send(

                '6287764868369',

                "💵 CASH DITERIMA DRIVER

Kode Booking:
{$booking->booking_code}

Customer:
{$booking->customer_name}

Total:
Rp " .
                    number_format(
                        $payment->amount,
                        0,
                        ',',
                        '.'
                    ) . "

Status:
CASH RECEIVED"
            );
        } catch (\Exception $e) {

            logger(
                'WA ADMIN CASH ERROR: ' .
                    $e->getMessage()
            );
        }


        try {

            WhatsappService::send(

                $booking->phone_number,

                "💵 PEMBAYARAN CASH DITERIMA

Halo {$booking->customer_name},

Pembayaran cash Anda telah diterima oleh driver.

Kode Booking:
{$booking->booking_code}

Total:
Rp " .
                    number_format(
                        $payment->amount,
                        0,
                        ',',
                        '.'
                    ) . "

Terima kasih telah menggunakan Sanu Travel 🚐"
            );
        } catch (\Exception $e) {

            logger(
                'WA CUSTOMER CASH ERROR: ' .
                    $e->getMessage()
            );
        }

        return redirect()->route(
            'driver.cash.success',
            $payment->id
        )->with(
            'success',
            'Cash berhasil diterima'
        );
    }

    public function cashSuccess($id)
    {
        $payment = Payment::with([
            'booking'
        ])->findOrFail($id);

        return view(
            'driver.cash-success',
            compact('payment')
        );
    }

    public function settle($id)
    {
        $payment = Payment::with('booking')->findOrFail($id);

        PaymentService::settle($payment);

        return back()->with('success', 'Pembayaran berhasil diselesaikan');
    }
}
