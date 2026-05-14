<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;
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
        $order = DeliveryOrder::where('driver_id', Auth::id())
            ->findOrFail($id);

        $order->update([
            'status' => 'ongoing'
        ]);

        return back()->with('success', 'Perjalanan dimulai');
    }

    public function finishTrip($id)
    {
        $order = DeliveryOrder::where('driver_id', Auth::id())
            ->findOrFail($id);

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Perjalanan selesai');
    }

    public function store($schedule_id)
    {
        $order = DeliveryOrder::create([
            'driver_id' => Auth::id(),
            'schedule_id' => $schedule_id,
            'status' => 'pending',
        ]);

        return response()->json($order);
    }

    public function updateStatus($id, Request $request)
    {
        $order = DeliveryOrder::where('driver_id', Auth::id())
            ->findOrFail($id);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status diperbarui');
    }
}