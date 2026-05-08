<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
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
            'service_id'        => 'required',
            'pickup_type'       => 'required',
            'pickup_date'       => 'required|date',
            'pickup_time'       => 'required',
            'phone_number'      => 'required',
            'pickup_location'   => 'required',
            'destination'       => 'required',
            'total_passengers'  => 'required|integer|min:1',
        ]);

        // HARGA
        if ($request->pickup_type === 'reguler') {

            $price = 300000 * $request->total_passengers;
        } else {

            $price = 600000;
        }

        // SIMPAN BOOKING
        $booking = Booking::create([

            'booking_code'      => 'BOOK-' . strtoupper(Str::random(8)),
            'service_id'        => $request->service_id,
            'user_id'           => Auth::id(),
            'pickup_type'       => $request->pickup_type,
            'pickup_date'       => $request->pickup_date,
            'pickup_time'       => $request->pickup_time,
            'phone_number'      => $request->phone_number,
            'pickup_location'   => $request->pickup_location,
            'destination'       => $request->destination,
            'total_passengers'  => $request->total_passengers,
            'price'             => $price,
        ]);

        // EMAIL
        Mail::send(
            'emails.booking-created',
            [
                'booking' => $booking
            ],
            function ($message) {
                $message->to('nylaadjah@gmail.com')
                    ->subject('Booking Baru Masuk');
            }
        );

        Mail::send(
            'emails.booking-payment',
            [
                'booking' => $booking
            ],
            function ($message) {

                $message->to(Auth::user()->email)
                    ->subject('Segera Lakukan Pembayaran');
            }
        );

        return redirect()
            ->route('customer.history')
            ->with('success', 'Booking berhasil dibuat!');
    }
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.history', compact('bookings'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id != Auth::id()) {

            abort(403);
        }

        $booking->status = 'cancel_request';

        $booking->save();

        Mail::send(
            'emails.cancel-request',
            [
                'booking' => $booking
            ],
            function ($message) {

                $message->to('nylaadjah@gmail.com')
                    ->subject('Pengajuan Cancel Booking');
            }
        );

        return back()->with(
            'success',
            'Pengajuan pembatalan berhasil dikirim.'
        );
    }

    public function approveCancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'cancelled';

        $booking->save();

        Mail::send(
            'emails.cancel-approved',
            [
                'booking' => $booking
            ],
            function ($message) use ($booking) {

                $message->to($booking->user->email)
                    ->subject('Pengajuan Cancel Disetujui');
            }
        );

        return back()->with(
            'success',
            'Cancel booking disetujui.'
        );
    }

    public function rejectCancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'confirmed';

        $booking->save();

        Mail::send(
            'emails.cancel-rejected',
            [
                'booking' => $booking
            ],
            function ($message) use ($booking) {

                $message->to($booking->user->email)
                    ->subject('Pengajuan Cancel Ditolak');
            }
        );

        return back()->with(
            'success',
            'Pengajuan cancel ditolak.'
        );
    }
}
