<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\Schedule;

class DeliveryOrderController extends Controller
{
    // 1. BUAT DO DARI SCHEDULE (ADMIN)
    public function store($schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);

        $do = DeliveryOrder::create([
            'schedule_id' => $schedule->id,
            'driver_id' => $schedule->driver_id,
            'status' => 'waiting',
        ]);

        return response()->json([
            'message' => 'Delivery Order dibuat',
            'data' => $do
        ]);
    }

    // 2. DRIVER LIHAT DO
    public function myOrders()
    {
        $do = DeliveryOrder::where('driver_id', auth()->id)
                ->with('schedule')
                ->get();

        return response()->json($do);
    }

    // 3. DRIVER MULAI PERJALANAN
    public function startTrip($id)
    {
        $do = DeliveryOrder::findOrFail($id);

        $do->update([
            'status' => 'on_trip'
        ]);

        return response()->json([
            'message' => 'Perjalanan dimulai'
        ]);
    }

    // 4. DRIVER SELESAI
    public function finishTrip($id)
    {
        $do = DeliveryOrder::findOrFail($id);

        $do->update([
            'status' => 'done'
        ]);

        return response()->json([
            'message' => 'Perjalanan selesai'
        ]);
    }
}