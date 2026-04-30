<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    // DRIVER LIHAT ORDER
    public function myOrders()
    {
        $driver = auth()->user()->driver;

        $orders = DeliveryOrder::where('driver_id', $driver->id)
            ->with(['booking', 'schedule'])
            ->get();

        return response()->json($orders);
    }

    // START
    public function startTrip($id)
    {
        $order = DeliveryOrder::findOrFail($id);

        $order->update([
            'status' => 'ongoing'
        ]);

        return response()->json(['message' => 'Perjalanan dimulai']);
    }

    // FINISH
    public function finishTrip($id)
    {
        $order = DeliveryOrder::findOrFail($id);

        $order->update([
            'status' => 'completed'
        ]);

        return response()->json(['message' => 'Perjalanan selesai']);
    }
}