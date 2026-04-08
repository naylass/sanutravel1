<?php

namespace App\Filament\Admin\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('booking_code')
                    ->label('Kode Booking')
                    ->copyable(),
                TextEntry::make('user.name')
                    ->label('Nama'),

                TextEntry::make('service.name')
                    ->label('Layanan'),

                TextEntry::make('pickup_time')
                    ->label('Waktu Penjemputan')
                    ->dateTime(),

                TextEntry::make('phone_number')
                    ->label('Nomor Telepon'),

                TextEntry::make('pickup_location')
                    ->label('Lokasi Penjemputan'),

                TextEntry::make('total_passengers')
                    ->label('Jumlah Penumpang')
                    ->numeric(),

                TextEntry::make('price')
                    ->label('Harga')
                    ->numeric(),

                TextEntry::make('status')
                    ->label('Status'),

                TextEntry::make('payment_status')
                    ->label('Status Pembayaran'),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
