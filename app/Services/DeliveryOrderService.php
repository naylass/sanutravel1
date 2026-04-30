<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryOrderCreatedMail;

class DeliveryOrderService
{
    public function generate(array $data): DeliveryOrder
    {
        return DB::transaction(function () use ($data) {

            $booking = Booking::with([
                'user',
                'schedule.driver',
                'schedule.vehicle'
            ])->findOrFail($data['booking_id']);

            $schedule = $booking->schedule;

            if (!$schedule || !$schedule->driver_id || !$schedule->vehicle_id) {
                throw new \Exception('Schedule belum lengkap');
            }

            if (DeliveryOrder::where('booking_id', $booking->id)->exists()) {
                throw new \Exception('DO sudah ada');
            }

            $deliveryOrder = DeliveryOrder::create([
                'booking_id' => $booking->id,
                'driver_id' => $schedule->driver_id,
                'vehicle_id' => $schedule->vehicle_id,
                'schedule_id' => $schedule->id,

                'departure_date' => $schedule->departure_date,
                'departure_time' => $schedule->departure_time,
                'pickup_point' => $schedule->pickup_point,
                'destination' => $booking->destination,

                'status' => 'prepared',
            ]);

            $deliveryOrder->load([
                'booking.user',
                'driver',
                'vehicle',
                'schedule'
            ]);

            // EMAIL DRIVER
            if ($deliveryOrder->driver?->email) {
                Mail::to($deliveryOrder->driver->email)
                    ->send(new DeliveryOrderCreatedMail($deliveryOrder));
            }

            return $deliveryOrder;
        });
    }
}