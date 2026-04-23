<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;

class DeliveryOrderService
{
    /**
     * Generate Delivery Order dari Booking
     */
    public function generate(array $data): DeliveryOrder
    {
        return DB::transaction(function () use ($data) {

            // Ambil booking + schedule + relasi driver & vehicle
            $booking = Booking::with([
                'schedule.driver',
                'schedule.vehicle'
            ])->findOrFail($data['booking_id']);

            // Validasi schedule wajib ada
            if (!$booking->schedule) {
                throw new \Exception('Booking belum memiliki schedule.');
            }

            $schedule = $booking->schedule;

            // Cegah duplicate Delivery Order
            $exists = DeliveryOrder::where('booking_id', $booking->id)->first();
            if ($exists) {
                throw new \Exception('Delivery Order untuk booking ini sudah dibuat.');
            }

            // Generate Delivery Order
            return DeliveryOrder::create([
                'booking_id'     => $booking->id,
                'driver_id'      => $schedule->driver_id,
                'vehicle_id'     => $schedule->vehicle_id,
                'schedule_id'    => $schedule->id,

                'departure_date' => $schedule->departure_date,
                'departure_time' => $schedule->departure_time,

                'pickup_point' => $booking->pickup_point ?? '-',
                'destination'   => $booking->destination ?? '-',

                'status'         => 'prepared',
            ]);
        });
    }
}
