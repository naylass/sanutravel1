<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('departure_datetime')
                    ->label('Tanggal & Waktu Keberangkatan')
                    ->dateTime('d M Y H:i'),

                TextEntry::make('pickup_point')
                    ->label('Titik Penjemputan'),

                TextEntry::make('destination')
                    ->label('Tujuan'),

                TextEntry::make('vehicle.brand')
                    ->label('Kendaraan'),

                TextEntry::make('driver.name')
                    ->label('Sopir'),

                TextEntry::make('service.name')
                    ->label('Layanan'),

                TextEntry::make('available_seats')
                    ->label('Kursi Tersedia')
                    ->numeric(),

                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime(),
            ]);
    }
}
