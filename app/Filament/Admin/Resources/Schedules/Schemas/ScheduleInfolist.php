<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextEntry::make('departure_date')
                ->label('Waktu Keberangkatan')
                ->formatStateUsing(function ($record) {
                    return \Carbon\Carbon::parse($record->departure_date . ' ' . $record->departure_time)
                        ->format('d M Y H:i');
                }),

            TextEntry::make('pickup_point')
                ->label('Titik Penjemputan'),

            TextEntry::make('destination')
                ->label('Tujuan'),

            TextEntry::make('vehicle.brand')
                ->label('Kendaraan'),

            TextEntry::make('driver.name')
                ->label('Sopir'),

            TextEntry::make('bookings')
                ->label('Layanan')
                ->formatStateUsing(function ($record) {
                    return $record->bookings
                        ->map(fn($b) => $b->service->name ?? '-')
                        ->unique()
                        ->join(', ');
                }),

            TextEntry::make('total_passengers')
                ->label('Jumlah Customer')
                ->formatStateUsing(fn($record) => $record->bookings->sum('total_passengers')),

            TextEntry::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime(),

            TextEntry::make('updated_at')
                ->label('Diperbarui Pada')
                ->dateTime(),
        ]);
    }
}
