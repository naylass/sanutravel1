<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\BookingPaymentMail;
use App\Mail\CancelApprovedMail;
use App\Mail\CancelRejectedMail;

class BookingController extends Controller
{
    public function create()
    {
        return view('customer.booking');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id'       => 'required',
            'area'             => 'required',
            'customer_name'    => 'required',
            'email'            => 'required|email',
            'phone_number'     => 'required|min:10|max:15',
            'pickup_date'      => 'required|date',
            'pickup_location'  => 'required',
            'destination'      => 'required',
            'total_passengers' => 'required|integer|min:1',
        ]);

        $service = Service::findOrFail($request->service_id);

        $serviceName = strtolower($service->name);

        $freeArea = ['cilegon', 'serang'];

        $pickupFee = in_array(strtolower($request->area), $freeArea)
            ? 0
            : 100000;

        if ($serviceName == 'reguler') {

            $basePrice = 300000;

            $totalPrice =
                $basePrice *
                $request->total_passengers;

            $pickupTime =
                $request->pickup_time;
        } else {

            $basePrice = 600000;

            $totalPrice = 600000;

            $pickupTime =
                $request->custom_time;
        }

        $departureDateTime = Carbon::parse(
            $request->pickup_date . ' ' . $pickupTime,
            'Asia/Jakarta'
        );

        $now = Carbon::now('Asia/Jakarta');

        $hoursDiff = $now->diffInHours(
            $departureDateTime,
            false
        );

        if (
            $departureDateTime->isToday()
            && $hoursDiff < 3
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Booking minimal 3 jam sebelum keberangkatan.'
                );
        }

        $totalPrice += $pickupFee;

        $booking = Booking::create([

            'service_id'       => $service->id,

            'customer_name'    => $request->customer_name,

            'email'            => $request->email,

            'phone_number'     => $request->phone_number,

            'booking_code'     =>
            'BOOK-' . strtoupper(Str::random(8)),

            'pickup_date'      => $request->pickup_date,

            'pickup_time'      => $pickupTime,

            'pickup_location'  => $request->pickup_location,

            'destination'      => $request->destination,

            'total_passengers' =>
            $request->total_passengers,

            'area'             => $request->area,

            'base_price'       => $basePrice,

            'pickup_fee'       => $pickupFee,

            'total_price'      => $totalPrice,

            'status'           => 'pending',
        ]);

        $message = "
🚐 BOOKING BERHASIL — SANU TRAVEL

Kode Booking:
{$booking->booking_code}

Nama:
{$booking->customer_name}

Layanan:
{$service->name}

Area:
{$booking->area}

Tujuan:
{$booking->destination}

Tanggal:
{$booking->pickup_date}

Jam:
{$booking->pickup_time}

Total Pembayaran:
Rp " . number_format(
            $booking->total_price,
            0,
            ',',
            '.'
        ) . "

Terima kasih 🙏
SANU TRAVEL
";

        WhatsappService::send(
            $booking->phone_number,
            $message
        );

        Mail::send(
            'emails.booking-created',
            [
                'booking' => $booking,
                'service' => $service,
            ],
            function ($message) {

                $message->to('nylaadjah@gmail.com')
                    ->subject('Booking Baru Masuk');
            }
        );

        try {

            Mail::to(
                $booking->email
            )->send(
                new BookingPaymentMail($booking)
            );
        } catch (\Exception $e) {

            logger(
                'EMAIL CUSTOMER ERROR: ' .
                    $e->getMessage()
            );
        }

        return redirect()
            ->route(
                'booking.success',
                [
                    'code' => $booking->booking_code
                ]
            )
            ->with(
                'success',
                'Booking berhasil dibuat'
            );
    }

    public function success($code)
    {
        $booking = Booking::where(
            'booking_code',
            $code
        )->first();

        if (!$booking) {

            return redirect('/booking/create')
                ->with(
                    'error',
                    'Booking tidak ditemukan'
                );
        }

        return view(
            'customer.booking-success',
            compact('booking')
        );
    }

    public function tracking(Request $request)
    {
        $bookings = collect();

        if (
            $request->filled('booking_code') &&
            $request->filled('phone_number')
        ) {

            $phone = preg_replace(
                '/[^0-9]/',
                '',
                $request->phone_number
            );

            $bookings = Booking::with([
                'payment',
                'service'
            ])
                ->where(
                    'booking_code',
                    $request->booking_code
                )
                ->where(
                    'phone_number',
                    $phone
                )
                ->latest()
                ->get();
        }

        return view(
            'customer.tracking',
            compact('bookings')
        );
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return back()->with('error', 'Booking tidak bisa dibatalkan');
        }

        $departureTime = Carbon::parse(
            $booking->pickup_date . ' ' . $booking->pickup_time
        );

        if (now()->gte($departureTime->copy()->subHours(6))) {
            return back()->with('error', 'Batas waktu cancel sudah lewat');
        }

        if ($booking->status === 'cancel_request') {
            return back()->with('error', 'Permintaan cancel sudah dikirim');
        }

        $booking->update(['status' => 'cancel_request']);

        try {
            Mail::send(
                'emails.cancel-request',
                ['booking' => $booking],
                function ($message) use ($booking) {
                    $message->to('nylaadjah@gmail.com')
                        ->subject(
                            'Permintaan Cancel Booking — ' .
                                $booking->booking_code
                        );
                }
            );
        } catch (\Exception $e) {
            logger('EMAIL ADMIN CANCEL REQUEST ERROR: ' . $e->getMessage());
        }

        try {
            WhatsappService::send(
                '6287764868369',
                "⚠️ PERMINTAAN CANCEL MASUK\n\n" .
                    "Kode Booking: {$booking->booking_code}\n" .
                    "Customer: {$booking->customer_name}\n" .
                    "No HP: {$booking->phone_number}\n" .
                    "Tujuan: {$booking->destination}\n" .
                    "Tgl Berangkat: {$booking->pickup_date} {$booking->pickup_time}\n\n" .
                    "Silakan approve atau reject di admin panel."
            );
        } catch (\Exception $e) {
            logger('WA ADMIN CANCEL REQUEST ERROR: ' . $e->getMessage());
        }

        try {
            WhatsappService::send(
                $booking->phone_number,
                "⏳ PERMINTAAN CANCEL DITERIMA\n\n" .
                    "Halo {$booking->customer_name},\n\n" .
                    "Permintaan cancel Anda telah diterima dan sedang diproses admin.\n\n" .
                    "📌 Kode Booking: {$booking->booking_code}\n" .
                    "🏁 Tujuan: {$booking->destination}\n\n" .
                    "Kami akan segera menghubungi Anda.\n\n" .
                    "Terima kasih, Sanu Travel 🚐"
            );
        } catch (\Exception $e) {
            logger('WA CUSTOMER CANCEL REQUEST ERROR: ' . $e->getMessage());
        }

        return back()->with('success', 'Permintaan cancel berhasil dikirim');
    }

    public function rejectCancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update(['status' => 'confirmed']);

        // =========================================================
        // EMAIL CUSTOMER
        // =========================================================
        try {
            if (!empty($booking->email)) {
                Mail::to($booking->email)
                    ->send(new CancelRejectedMail($booking));
            }
        } catch (\Exception $e) {
            logger('EMAIL CANCEL REJECT ERROR: ' . $e->getMessage());
        }

        // =========================================================
        // WA CUSTOMER
        // =========================================================
        try {
            WhatsappService::send(
                $booking->phone_number,
                "🚐 PERMINTAAN CANCEL DITOLAK\n\n" .
                    "Halo {$booking->customer_name},\n\n" .
                    "Permintaan cancel Anda DITOLAK oleh admin.\n" .
                    "Booking Anda tetap aktif.\n\n" .
                    "📌 Kode Booking: {$booking->booking_code}\n" .
                    "🏁 Tujuan: {$booking->destination}\n\n" .
                    "Terima kasih, Sanu Travel 🚐"
            );
        } catch (\Exception $e) {
            logger('WA CANCEL REJECT ERROR: ' . $e->getMessage());
        }

        try {
            WhatsappService::send(
                '6287764868369',
                "🚫 CANCEL DITOLAK\n\n" .
                    "Kode: {$booking->booking_code}\n" .
                    "Customer: {$booking->customer_name}\n" .
                    "Tujuan: {$booking->destination}\n" .
                    "Status: CONFIRMED (kembali aktif)"
            );
        } catch (\Exception $e) {
            logger('WA ADMIN REJECT CANCEL ERROR: ' . $e->getMessage());
        }

        return back()->with('success', 'Cancel booking ditolak');
    }

    public function approveCancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update(['status' => 'cancelled']);

        // =========================================================
        // EMAIL CUSTOMER
        // =========================================================
        try {
            if (!empty($booking->email)) {
                Mail::to($booking->email)
                    ->send(new CancelApprovedMail($booking));
            }
        } catch (\Exception $e) {
            logger('EMAIL CANCEL APPROVED ERROR: ' . $e->getMessage());
        }

        // =========================================================
        // WA CUSTOMER
        // =========================================================
        try {
            WhatsappService::send(
                $booking->phone_number,
                "❌ BOOKING DIBATALKAN\n\n" .
                    "Halo {$booking->customer_name},\n\n" .
                    "Booking Anda telah DIBATALKAN oleh admin.\n\n" .
                    "📌 Kode Booking: {$booking->booking_code}\n" .
                    "🏁 Tujuan: {$booking->destination}\n\n" .
                    "Terima kasih, Sanu Travel 🚐"
            );
        } catch (\Exception $e) {
            logger('WA CANCEL APPROVED ERROR: ' . $e->getMessage());
        }

        // =========================================================
        // WA ADMIN — konfirmasi sudah approve
        // =========================================================
        try {
            WhatsappService::send(
                '6287764868369',
                "✅ CANCEL DISETUJUI\n\n" .
                    "Kode: {$booking->booking_code}\n" .
                    "Customer: {$booking->customer_name}\n" .
                    "Tujuan: {$booking->destination}\n" .
                    "Status: CANCELLED"
            );
        } catch (\Exception $e) {
            logger('WA ADMIN APPROVE CANCEL ERROR: ' . $e->getMessage());
        }

        return back()->with('success', 'Booking berhasil dibatalkan');
    }
}
