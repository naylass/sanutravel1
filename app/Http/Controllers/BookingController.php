<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            'area'               => 'required',
            'customer_name'      => 'required',
            'email'              => 'required|email',
            'phone_number'       => 'required|min:10|max:15',
            'pickup_date'        => 'required|date',
            'pickup_location'    => 'required',
            'destination'        => 'required',
            'total_passengers'   => 'required|integer|min:1',
        ]);

        $service = Service::findOrFail($request->service_id);

        $serviceName = strtolower($service->name);

        $freeArea = ['cilegon', 'serang'];

        $pickupFee = in_array(strtolower($request->area), $freeArea)
            ? 0
            : 50000;

        if ($serviceName == 'reguler') {

            $basePrice = 300000;
            $totalPrice = $basePrice * $request->total_passengers;

            $pickupTime = $request->pickup_time; // slot tetap

        } else {

            $basePrice = 600000;
            $totalPrice = 600000;

            $pickupTime = $request->custom_time;
        }

        $totalPrice += $pickupFee;

        $booking = Booking::create([

            'service_id'       => $service->id,
            'customer_name'    => $request->customer_name,
            'email'            => $request->email,
            'phone_number'     => $request->phone_number,

            'booking_code'     => 'BOOK-' . strtoupper(Str::random(8)),

            'pickup_date'      => $request->pickup_date,
            'pickup_time'      => $pickupTime,

            'pickup_location'  => $request->pickup_location,
            'destination'      => $request->destination,

            'total_passengers' => $request->total_passengers,
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
Rp " . number_format($booking->total_price, 0, ',', '.') . "

Terima kasih 🙏
SANU TRAVEL
";

        WhatsappService::send($booking->phone_number, $message);

        Mail::send('emails.booking-created', [
            'booking' => $booking,
            'service' => $service,
        ], function ($message) {

            $message->to('nylaadjah@gmail.com')
                ->subject('Booking Baru Masuk');
        });

        /*
        |--------------------------------------------------------------------------
        | REDIRECT SUCCESS (FIXED)
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'booking.success',
                [
                    'code' => $booking->booking_code
                ]
            )
            ->with('success', 'Booking berhasil dibuat');
    }

    public function success($code)
    {
        $booking = Booking::where('booking_code', $code)->first();

        if (!$booking) {
            return redirect('/booking/create')
                ->with('error', 'Booking tidak ditemukan');
        }

        return view('customer.booking-success', compact('booking'));
    }


    public function tracking(Request $request)
    {
        $bookings = collect();

        if (
            $request->filled('booking_code') &&
            $request->filled('phone_number')
        ) {

            $phone = preg_replace('/[^0-9]/', '', $request->phone_number);

            $bookings = Booking::with([
                'payment',
                'service'
            ])
                ->where('booking_code', $request->booking_code)
                ->where('phone_number', $phone)
                ->latest()
                ->get();
        }

        return view('customer.tracking', compact('bookings'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return back()->with('error', 'Booking tidak bisa dibatalkan');
        }

        $booking->update([
            'status' => 'cancel_request'
        ]);

        Mail::send('emails.cancel-request', [
            'booking' => $booking
        ], function ($message) {

            $message->to('nylaadjah@gmail.com')
                ->subject('Permintaan Cancel Booking');
        });

        return back()->with('success', 'Permintaan cancel berhasil dikirim');
    }

    public function approveCancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'cancelled'
        ]);

        Mail::send('emails.cancel-approved', [
            'booking' => $booking
        ], function ($message) use ($booking) {

            $message->to($booking->email)
                ->subject('Booking Dibatalkan');
        });

        WhatsappService::send(
            $booking->phone_number,
            "❌ BOOKING DIBATALKAN\n\nKode: {$booking->booking_code}\nTujuan: {$booking->destination}"
        );

        return back()->with('success', 'Booking berhasil dibatalkan');
    }

    public function rejectCancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'confirmed'
        ]);

        Mail::send('emails.cancel-rejected', [
            'booking' => $booking
        ], function ($message) use ($booking) {

            $message->to($booking->email)
                ->subject('Cancel Booking Ditolak');
        });

        WhatsappService::send(
            $booking->phone_number,
            "🚐 CANCEL DITOLAK\n\nBooking Anda tetap aktif\nKode: {$booking->booking_code}"
        );

        return back()->with('success', 'Cancel booking ditolak');
    }
}
