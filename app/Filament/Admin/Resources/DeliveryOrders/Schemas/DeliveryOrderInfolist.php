<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class DeliveryOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('booking.booking_code')
                    ->label('Kode Booking'),

                TextEntry::make('driver.name')
                    ->label('Sopir'),

                TextEntry::make('vehicle.plate_number')
                    ->label('Nomor Kendaraan'),

                TextEntry::make('schedule.departure_datetime')
                    ->label('Waktu Keberangkatan')
                    ->dateTime('d M Y H:i'),  

                TextEntry::make('pickup_point')
                    ->label('Titik Penjemputan'),

                TextEntry::make('destination')
                    ->label('Tujuan'),

                TextEntry::make('status')
                    ->label('Status'),
 
                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime(),
            ]);
    }
}