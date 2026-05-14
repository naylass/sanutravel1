<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Carbon\Carbon;

class ScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // =========================
            // DRIVER
            // =========================
            TextEntry::make('driver.name')
                ->label('Driver')
                ->icon('heroicon-o-user'),

            // =========================
            // VEHICLE
            // =========================
            TextEntry::make('vehicle.brand')
                ->label('Kendaraan')
                ->icon('heroicon-o-truck'),

            // =========================
            // CUSTOMER (CORE LOGIC)
            // =========================
            TextEntry::make('customer_name')
                ->label('Customer')
                ->icon('heroicon-o-users')
                ->state(function ($record) {

                    $names = $record->bookings
                        ->pluck('customer.name')
                        ->filter()
                        ->unique();

                    // 🔴 EKSKLUSIF
                    if ($record->bookings->count() === 1) {
                        return $names->first() ?? '-';
                    }

                    // 🟢 REGULER
                    return $names->implode(', ');
                })
                ->badge(),

            // =========================
            // BOOKING CODES
            // =========================
            TextEntry::make('booking_codes')
                ->label('Kode Booking')
                ->icon('heroicon-o-ticket')
                ->state(fn ($record) =>
                    $record->bookings
                        ->pluck('booking_code')
                        ->implode(', ')
                ),

            // =========================
            // PHONE NUMBERS
            // =========================
            TextEntry::make('phones')
                ->label('No HP Customer')
                ->icon('heroicon-o-phone')
                ->state(fn ($record) =>
                    $record->bookings
                        ->pluck('phone_number')
                        ->unique()
                        ->implode(', ')
                ),

            // =========================
            // ROUTE
            // =========================
            TextEntry::make('route')
                ->label('Rute')
                ->icon('heroicon-o-map-pin')
                ->state(fn ($record) =>
                    $record->pickup_point . ' → ' . $record->destination
                ),

            // =========================
            // SCHEDULE TIME
            // =========================
            TextEntry::make('departure')
                ->label('Jadwal Keberangkatan')
                ->icon('heroicon-o-clock')
                ->state(function ($record) {

                    return Carbon::parse(
                        $record->departure_date . ' ' . $record->departure_time
                    )->format('d M Y H:i');
                }),

            // =========================
            // TOTAL PASSENGER
            // =========================
            TextEntry::make('total_passengers')
                ->label('Total Penumpang')
                ->icon('heroicon-o-user-group')
                ->state(fn ($record) =>
                    $record->bookings->sum('total_passengers') . ' orang'
                )
                ->badge(),

            // =========================
            // TYPE
            // =========================
            TextEntry::make('type')
                ->label('Tipe Schedule')
                ->icon('heroicon-o-tag')
                ->state(function ($record) {

                    return $record->bookings->count() > 1
                        ? 'Reguler (Gabungan)'
                        : 'Eksklusif';
                })
                ->badge()
                ->color(fn ($record) =>
                    $record->bookings->count() > 1 ? 'success' : 'warning'
                ),

            // =========================
            // CREATED
            // =========================
            TextEntry::make('created_at')
                ->label('Dibuat')
                ->icon('heroicon-o-plus-circle')
                ->dateTime('d M Y H:i'),

            // =========================
            // UPDATED
            // =========================
            TextEntry::make('updated_at')
                ->label('Diperbarui')
                ->icon('heroicon-o-pencil-square')
                ->dateTime('d M Y H:i'),
        ]);
    }
}