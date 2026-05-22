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
        $payment = Payment::with('booking')
            ->findOrFail($id);

        $booking = $payment->booking;

        $payment->update([
            'status' => 'verified',
            'verified_at' => now('Asia/Jakarta'),
        ]);

        $booking->update([
            'status' => 'confirmed',
        ]);


        $pdf = Pdf::loadView(
            'pdf.payment-receipt',
            compact('booking', 'payment')
        );

        $pdfName =
            'receipt-' .
            $booking->booking_code .
            '.pdf';

        $folder =
            storage_path('app/public/receipts');

        if (!file_exists($folder)) {

            mkdir($folder, 0777, true);
        }

        $pdfPath = $folder . '/' . $pdfName;

        file_put_contents(
            $pdfPath,
            $pdf->output()
        );

        $pdfUrl =
            asset(
                'storage/receipts/' .
                    $pdfName
            );

        try {

            if (!empty($booking->email)) {

                Mail::to($booking->email)
                    ->send(new PaymentVerifiedMail($payment));
            }
        } catch (\Exception $e) {
            logger('EMAIL VERIFY ERROR: ' . $e->getMessage());
        }

        try {

            $phone = $booking->phone_number;

            if (!empty($phone)) {

                WhatsappService::send(

                    $phone,

                    "✅ PEMBAYARAN BERHASIL DIVERIFIKASI

Halo {$booking->customer_name},

Pembayaran Anda telah berhasil diverifikasi oleh admin.

📌 Kode Booking:
{$booking->booking_code}

📍 Status:
BOOKING DIKONFIRMASI

Terima kasih 🚐"
                );
            }
        } catch (\Exception $e) {
            logger('WA VERIFY ERROR: ' . $e->getMessage());
        }

        try {

            $pdfPublicUrl = url('storage/receipts/' . $pdfName);

            WhatsappService::sendDocument(

                $booking->phone_number,
                $pdfPublicUrl,
                "📄 RECEIPT PEMBAYARAN\n\nKode Booking: {$booking->booking_code}"
            );
        } catch (\Exception $e) {
            logger('WA PDF ERROR: ' . $e->getMessage());
        }

        try {

            WhatsappService::send(

                '6287764868369',

                "✅ PEMBAYARAN VERIFIED

Kode:
{$booking->booking_code}

Customer:
{$booking->customer_name}

Total:
Rp " .
                    number_format(
                        $booking->total_price,
                        0,
                        ',',
                        '.'
                    )
            );
        } catch (\Exception $e) {

            logger(
                'WA ADMIN VERIFY ERROR: ' .
                    $e->getMessage()
            );
        }

        return back()->with(
            'success',
            'Pembayaran berhasil diverifikasi'
        );
    }

    public function reject($id)
    {
        $payment = Payment::with('booking')
            ->findOrFail($id);

        $booking = $payment->booking;

        $payment->update([
            'status' => 'rejected',
        ]);

        $booking->update([
            'status' => 'pending',
        ]);

        // =========================
        // WA CUSTOMER
        // =========================
        try {

            $phone = $booking->phone_number;

            if (!empty($phone)) {

                WhatsappService::send(

                    $phone,

                    "❌ PEMBAYARAN DITOLAK

Halo {$booking->customer_name},

Pembayaran Anda ditolak oleh admin.

📌 Kode Booking:
{$booking->booking_code}

Silakan upload ulang bukti pembayaran.

Terima kasih 🚐"
                );
            }
        } catch (\Exception $e) {
            logger('WA REJECT ERROR: ' . $e->getMessage());
        }

        // =========================
        // EMAIL CUSTOMER
        // =========================
        try {

            if (!empty($booking->email)) {

                Mail::to($booking->email)
                    ->send(new PaymentRejectedMail($payment));
            }
        } catch (\Exception $e) {
            logger('EMAIL REJECT ERROR: ' . $e->getMessage());
        }

        // =========================
        // WA ADMIN
        // =========================
        try {

            WhatsappService::send(

                '6287764868369',

                "❌ PEMBAYARAN DITOLAK

Kode Booking:
{$booking->booking_code}

Customer:
{$booking->customer_name}

Status:
PAYMENT REJECTED"
            );
        } catch (\Exception $e) {
            logger('WA ADMIN REJECT ERROR: ' . $e->getMessage());
        }

        return back()->with(
            'error',
            'Pembayaran berhasil ditolak'
        );
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
        $payment = Payment::with('booking')
            ->findOrFail($id);

        $booking = $payment->booking;

        $payment->update([

            'status' => 'settled',

            'verified_at' => now('Asia/Jakarta'),

            'settled_to_admin_at' => now('Asia/Jakarta'),
        ]);

        $booking->update([

            'status' => 'completed',
        ]);

        if (!Income::where('payment_id', $payment->id)->exists()) {

            Income::create([

                'payment_id'   => $payment->id,

                'amount'       => $payment->amount,

                'income_type'  => 'booking',

                'description'  =>
                'Income booking ' .
                    $booking->booking_code,

                'income_date'  => now('Asia/Jakarta'),
            ]);
        }

        try {

            if (!empty($booking->email)) {

                Mail::to($booking->email)
                    ->send(
                        new PaymentSettledMail($payment)
                    );
            }
        } catch (\Exception $e) {

            logger(
                'EMAIL SETTLED ERROR: ' .
                    $e->getMessage()
            );
        }

        try {

            WhatsappService::send(

                $booking->phone_number,

                "✅ PEMBAYARAN SELESAI

Kode Booking:
{$booking->booking_code}

Halo {$booking->customer_name},

Pembayaran Anda telah selesai diproses admin.

Status:
SELESAI

Terima kasih telah menggunakan Sanu Travel 🚐"
            );
        } catch (\Exception $e) {

            logger('WA SETTLED ERROR: ' . $e->getMessage(), [
                'booking_id' => $booking->id ?? null,
                'phone' => $booking->phone_number
            ]);
        }

        return back()->with(
            'success',
            'Pembayaran berhasil diselesaikan'
        );
    }
}
