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

            TextEntry::make('departure_date')
                ->label('Waktu Keberangkatan')
                ->icon('heroicon-o-clock')
                ->formatStateUsing(function ($record) {
                    return Carbon::parse($record->departure_date . ' ' . $record->departure_time)
                        ->format('d M Y H:i');
                }),

            TextEntry::make('pickup_point')
                ->label('Titik Penjemputan')
                ->icon('heroicon-o-map-pin'),

            TextEntry::make('destination')
                ->label('Tujuan')
                ->icon('heroicon-o-flag'),

            TextEntry::make('vehicle.brand')
                ->label('Kendaraan')
                ->icon('heroicon-o-truck')
                ->formatStateUsing(fn($state) => $state ?? '-'),

            TextEntry::make('driver.name')
                ->label('Sopir')
                ->icon('heroicon-o-user')
                ->formatStateUsing(fn($state) => $state ?? '-'),

            TextEntry::make('bookings')
                ->label('Layanan')
                ->icon('heroicon-o-ticket')
                ->formatStateUsing(function ($record) {

                    return $record->bookings
                        ->pluck('service.name')
                        ->filter()
                        ->unique()
                        ->implode(', ') ?: '-';
                }),

            TextEntry::make('total_penumpang')
                ->label('Jumlah Penumpang')
                ->state(function ($record) {

                    return $record->bookings()
                        ->sum('total_passengers') . ' orang';
                }),

            TextEntry::make('created_at')
                ->label('Dibuat Pada')
                ->icon('heroicon-o-plus-circle')
                ->formatStateUsing(
                    fn($state) =>
                    Carbon::parse($state)->format('d M Y H:i')
                ),

            TextEntry::make('updated_at')
                ->label('Diperbarui Pada')
                ->icon('heroicon-o-pencil-square')
                ->formatStateUsing(
                    fn($state) =>
                    Carbon::parse($state)->format('d M Y H:i')
                ),
        ]);
    }
}
