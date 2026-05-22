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

            TextEntry::make('driver.name')
                ->label('Driver')
                ->icon('heroicon-o-user'),

            TextEntry::make('vehicle.brand')
                ->label('Kendaraan')
                ->icon('heroicon-o-truck'),

            TextEntry::make('customer_name')
                ->label('Customer')
                ->icon('heroicon-o-users')
                ->badge()
                ->state(function ($record) {

                    $names = $record->bookings
                        ->pluck('customer_name')
                        ->filter()
                        ->unique()
                        ->values();

                    if ($names->isEmpty()) {
                        return '-';
                    }

                    if ($record->bookings->count() === 1) {
                        return $names->first();
                    }

                    return $names->implode(', ');
                })
                ->badge(),

            TextEntry::make('booking_codes')
                ->label('Kode Booking')
                ->icon('heroicon-o-ticket')
                ->state(
                    fn($record) =>
                    $record->bookings
                        ->pluck('booking_code')
                        ->implode(', ')
                ),

            TextEntry::make('phones')
                ->label('No HP Customer')
                ->icon('heroicon-o-phone')
                ->state(
                    fn($record) =>
                    $record->bookings
                        ->pluck('phone_number')
                        ->unique()
                        ->implode(', ')
                ),

            TextEntry::make('route')
                ->label('Rute')
                ->icon('heroicon-o-map-pin')
                ->state(
                    fn($record) =>
                    $record->pickup_point . ' → ' . $record->destination
                ),

            TextEntry::make('departure')
                ->label('Jadwal Keberangkatan')
                ->icon('heroicon-o-clock')
                ->state(function ($record) {

                    return Carbon::parse(
                        $record->departure_date . ' ' . $record->departure_time
                    )->format('d M Y H:i');
                }),

            TextEntry::make('total_passengers')
                ->label('Total Penumpang')
                ->icon('heroicon-o-user-group')
                ->state(
                    fn($record) =>
                    $record->bookings->sum('total_passengers') . ' orang'
                )
                ->badge(),

            TextEntry::make('type')
                ->label('Tipe Schedule')
                ->icon('heroicon-o-tag')

                ->state(function ($record) {

                    $booking = $record->bookings->first();

                    if (!$booking || !$booking->service) {
                        return '-';
                    }

                    return strtolower($booking->service->name) === 'reguler'
                        ? 'Reguler'
                        : 'Eksklusif';
                })

                ->badge()

                ->color(function ($record) {

                    $booking = $record->bookings->first();

                    if (!$booking || !$booking->service) {
                        return 'gray';
                    }

                    return strtolower($booking->service->name) === 'reguler'
                        ? 'success'
                        : 'warning';
                }),

            TextEntry::make('created_at')
                ->label('Dibuat')
                ->icon('heroicon-o-plus-circle')
                ->dateTime('d M Y H:i'),

            TextEntry::make('updated_at')
                ->label('Diperbarui')
                ->icon('heroicon-o-pencil-square')
                ->dateTime('d M Y H:i'),
        ]);
    }
}
