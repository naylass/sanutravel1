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

            // 🔥 LOAD RELATION YANG ADA AJA
            $booking = Booking::with([
                'schedule.driver',
                'schedule.vehicle'
            ])->findOrFail($data['booking_id']);

            $schedule = $booking->schedule;

            // 🚫 BELUM ADA DRIVER / MOBIL
            if (
                !$schedule ||
                !$schedule->driver_id ||
                !$schedule->vehicle_id
            ) {

                throw new \Exception(
                    'Schedule belum lengkap'
                );
            }

            // 🚫 SUDAH PUNYA DO
            if (
                DeliveryOrder::where(
                    'booking_id',
                    $booking->id
                )->exists()
            ) {

                throw new \Exception(
                    'Delivery Order sudah ada'
                );
            }

            // ✅ CREATE DELIVERY ORDER
            $deliveryOrder = DeliveryOrder::create([

                'booking_id' => $booking->id,

                'driver_id' => $schedule->driver_id,

                'vehicle_id' => $schedule->vehicle_id,

                'schedule_id' => $schedule->id,

                'departure_date' => $schedule->departure_date,

                'departure_time' => $schedule->departure_time,

                // 🔥 INI YANG BENAR
                'pickup_point' => $booking->pickup_location,

                'destination' => $booking->destination,

                'status' => 'prepared',
            ]);

            // 🔥 LOAD RELATION YANG VALID
            $deliveryOrder->load([
                'booking',
                'driver',
                'vehicle',
                'schedule'
            ]);

            // 📧 EMAIL DRIVER
            if ($deliveryOrder->driver?->email) {

                Mail::to($deliveryOrder->driver->email)
                    ->send(
                        new DeliveryOrderCreatedMail(
                            $deliveryOrder
                        )
                    );
            }

            return $deliveryOrder;
        });
    }
}