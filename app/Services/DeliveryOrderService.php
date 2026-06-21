<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryOrderCreatedMail;
use App\Mail\DriverAssignedCashMail;

class DeliveryOrderService
{
    public function generate(array $data): DeliveryOrder
    {
        return DB::transaction(function () use ($data) {

            $booking = Booking::with([
                'schedule.driver',
                'schedule.vehicle',
                'payment',
            ])->findOrFail($data['booking_id']);

            $schedule = $booking->schedule;

            if (!$schedule || !$schedule->driver_id || !$schedule->vehicle_id) {
                throw new \Exception('Schedule belum lengkap');
            }

            if (DeliveryOrder::where('booking_id', $booking->id)->exists()) {
                throw new \Exception('Delivery Order sudah ada');
            }

            $deliveryOrder = DeliveryOrder::create([
                'booking_id'     => $booking->id,
                'driver_id'      => $schedule->driver_id,
                'vehicle_id'     => $schedule->vehicle_id,
                'schedule_id'    => $schedule->id,
                'departure_date' => $schedule->departure_date,
                'departure_time' => $schedule->departure_time,
                'pickup_point'   => $booking->pickup_location,
                'destination'    => $booking->destination,
                'status'         => 'prepared',
            ]);

            $booking->update(['status' => 'confirmed']);

            if ($schedule) {
                Booking::where('schedule_id', $schedule->id)
                    ->where('id', '!=', $booking->id)
                    ->whereIn('status', ['pending'])
                    ->whereHas(
                        'payment',
                        fn($q) =>
                        $q->whereIn('status', ['verified', 'settled', 'cash_received'])
                    )
                    ->update(['status' => 'confirmed']);
            }

            $deliveryOrder->load([
                'booking',
                'driver',
                'vehicle',
                'schedule',
            ]);

            if (!empty($deliveryOrder->driver?->email)) {
                try {
                    Mail::to($deliveryOrder->driver->email)
                        ->send(new DeliveryOrderCreatedMail($deliveryOrder));
                } catch (\Exception $e) {
                    logger('EMAIL DO ERROR: ' . $e->getMessage());
                }
            }

            if (
                !empty($deliveryOrder->driver?->email) &&
                $booking->payment?->payment_method === 'cash'
            ) {
                try {
                    Mail::to($deliveryOrder->driver->email)
                        ->send(new DriverAssignedCashMail($booking));
                } catch (\Exception $e) {
                    logger('EMAIL CASH REMINDER ERROR: ' . $e->getMessage());
                }
            }

            return $deliveryOrder;
        });
    }
}
