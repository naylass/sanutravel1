<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DeliveryOrder;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryStatusUpdatedMail;

class DriverController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $driver = Driver::where(
            'email',
            $user->email
        )->first();

        $customerCount = DeliveryOrder::with('booking')

            ->where(
                'driver_id',
                $driver?->id
            )

            ->whereIn('status', [
                'prepared',
                'ongoing'
            ])
            ->get()
            ->sum(function ($order) {

                return $order->booking?->total_passengers ?? 0;
            });

        $activeTrips = DeliveryOrder::where('driver_id', $driver?->id)
            ->whereIn('status', ['prepared', 'ongoing'])
            ->count();

        return view('driver.dashboard', [

            'driver' =>
            $driver,

            'customerCount' =>
            $customerCount,

            'activeTrips'  => $activeTrips,
        ]);
    }

    public function delivery()
    {
        $user = Auth::user();

        $driver = Driver::where(
            'email',
            $user->email
        )->first();

        $orders = DeliveryOrder::with([

            'booking',
            'schedule',
            'vehicle',

        ])

            ->where(
                'driver_id',
                $driver?->id
            )

            ->latest()

            ->get();

        return view(
            'driver.delivery',

            compact(
                'orders',
                'driver'
            )
        );
    }

    public function updateStatus(
        Request $request,
        $id
    ) {

        $request->validate([

            'status' =>
            'required|in:ongoing,completed,cancel',
        ]);

        $user = Auth::user();

        $driver = Driver::where(
            'email',
            $user->email
        )->first();


        $delivery = DeliveryOrder::with([

            'booking',
            'schedule',
            'vehicle',

        ])

            ->where(
                'id',
                $id
            )

            ->where(
                'driver_id',
                $driver?->id
            )

            ->firstOrFail();


        if (
            $delivery->status === 'prepared'
            &&
            $request->status !== 'ongoing'
        ) {

            return back()->with(

                'error',

                'Harus mulai perjalanan terlebih dahulu'
            );
        }

        if (
            $delivery->status === 'completed'
        ) {

            return back()->with(

                'error',

                'Order sudah selesai'
            );
        }

        if (
            $delivery->status === 'cancel'
        ) {

            return back()->with(

                'error',

                'Order sudah dibatalkan'
            );
        }

        $delivery->update([

            'status' =>
            $request->status
        ]);

        $statusText = match ($request->status) {

            'prepared' =>
            'Sedang Bersiap',

            'ongoing' =>
            'Perjalanan Sedang Berlangsung',

            'completed' =>
            'Perjalanan Selesai',

            'cancel' =>
            'Perjalanan Dibatalkan',

            default =>
            ucfirst($request->status),
        };

        try {

            if ($delivery->booking?->email) {

                Mail::to(
                    $delivery->booking->email
                )

                    ->send(
                        new DeliveryStatusUpdatedMail($delivery)
                    );
            }
        } catch (\Exception $e) {

            logger(
                'EMAIL DELIVERY STATUS ERROR: ' .
                    $e->getMessage()
            );
        }

        try {

            WhatsappService::send(

                $delivery->booking->phone_number,

                "📢 UPDATE STATUS PERJALANAN

Kode Booking:
{$delivery->booking->booking_code}

Customer:
{$delivery->booking->customer_name}

Driver:
{$driver->name}

Status:
{$statusText}

Tujuan:
{$delivery->booking->destination}

Terima kasih telah menggunakan layanan Sanu Travel 🚐"
            );
        } catch (\Exception $e) {

            logger(
                'WA DELIVERY STATUS ERROR: ' .
                    $e->getMessage()
            );
        }

        return back()->with(

            'success',

            'Status berhasil diupdate'
        );
    }
}
