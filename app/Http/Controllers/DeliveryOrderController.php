<?php

namespace App\Http\Controllers;

use App\Mail\DriverAssignedCashMail;
use App\Models\Booking;
use App\Models\DeliveryOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderController extends Controller
{
    public function index()
    {
        $orders = DeliveryOrder::where('driver_id', Auth::id())
            ->with(['booking', 'schedule'])
            ->latest()
            ->get();

        return view('driver.delivery', compact('orders'));
    }

    public function myOrders()
    {
        $orders = DeliveryOrder::where('driver_id', Auth::id())
            ->with(['booking', 'schedule'])
            ->get();

        return response()->json($orders);
    }

    public function startTrip($id)
    {
        $order = DeliveryOrder::with(['booking', 'schedule'])
            ->where('driver_id', Auth::id())
            ->findOrFail($id);

        $order->update(['status' => 'ongoing']);

        // Update semua booking di schedule yang sama
        if ($order->schedule_id) {
            Booking::where('schedule_id', $order->schedule_id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->update(['status' => 'on_progress']);
        }

        // Fallback: booking langsung relasi ke DO ini
        if ($order->booking_id) {
            Booking::where('id', $order->booking_id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->update(['status' => 'on_progress']);
        }

        return back()->with('success', 'Perjalanan dimulai');
    }

    public function finishTrip($id)
    {
        $order = DeliveryOrder::with(['booking', 'schedule'])
            ->where('driver_id', Auth::id())
            ->findOrFail($id);

        $order->update(['status' => 'completed']);

        // Update semua booking di schedule yang sama
        if ($order->schedule_id) {
            Booking::where('schedule_id', $order->schedule_id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->update(['status' => 'completed']);
        }

        // Fallback: booking langsung relasi ke DO ini
        if ($order->booking_id) {
            Booking::where('id', $order->booking_id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->update(['status' => 'completed']);
        }

        return back()->with('success', 'Perjalanan selesai');
    }

    public function store($schedule_id)
    {
        $order = DeliveryOrder::create([
            'driver_id'   => Auth::id(),
            'schedule_id' => $schedule_id,
            'status'      => 'pending',
        ]);

        $order->load([
            'booking.payment',
            'driver',
            'schedule'
        ]);

        $booking = $order->booking;

        if (
            $booking &&
            $booking->payment &&
            $booking->payment->payment_method === 'cash'
        ) {
            try {
                if (!empty($order->driver?->email)) {
                    Mail::to($order->driver->email)
                        ->send(new DriverAssignedCashMail($booking));
                }
            } catch (\Exception $e) {
                logger('EMAIL DRIVER CASH ERROR: ' . $e->getMessage(), [
                    'order_id'  => $order->id,
                    'driver_id' => $order->driver_id ?? null,
                ]);
            }
        }

        return response()->json($order);
    }

    public function updateStatus($id, Request $request)
    {
        $order = DeliveryOrder::where('driver_id', Auth::id())
            ->findOrFail($id);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status diperbarui');
    }
}
