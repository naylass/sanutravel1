<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    // 🔥 WAJIB: isi sebelum insert ke DB
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $vehicle = \App\Models\Vehicle::find($data['vehicle_id']);

        $bookings = \App\Models\Booking::whereIn('id', $data['bookings'] ?? [])->get();

        $totalPassengers = $bookings->sum('total_passengers');

        $data['available_seats'] = $vehicle
            ? $vehicle->capacity - $totalPassengers
            : 0;

        return $data;
    }

    // 🔥 setelah schedule dibuat
    protected function afterCreate(): void
    {
        $bookings = $this->data['bookings'] ?? [];

        foreach ($bookings as $bookingId) {
            \App\Models\Booking::where('id', $bookingId)
                ->update([
                    'schedule_id' => $this->record->id,
                    'status' => 'confirmed'
                ]);
        }
    }
}