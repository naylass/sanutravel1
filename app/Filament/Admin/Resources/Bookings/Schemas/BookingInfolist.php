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

                // 🔢 BOOKING CODE
                TextEntry::make('booking_code')
                    ->label('Kode Booking')
                    ->copyable(),

                // 👤 CUSTOMER
                TextEntry::make('customer.name')
                    ->label('Customer'),

                // 🚘 SERVICE
                TextEntry::make('service.name')
                    ->label('Layanan'),

                // 📍 PICKUP AREA
                TextEntry::make('pickupArea.name')
                    ->label('Area Pickup'),

                // 📅 TANGGAL
                TextEntry::make('pickup_date')
                    ->label('Tanggal Penjemputan')
                    ->date(),

                // ⏰ JAM
                TextEntry::make('pickup_time')
                    ->label('Jam Penjemputan'),

                // 📞
                TextEntry::make('phone_number')
                    ->label('Nomor Telepon'),

                // 📍 ALAMAT
                TextEntry::make('pickup_location')
                    ->label('Alamat Jemput'),

                // 🎯 TUJUAN
                TextEntry::make('destination')
                    ->label('Tujuan'),

                // 👥
                TextEntry::make('total_passengers')
                    ->label('Jumlah Penumpang'),

                // 💰 BREAKDOWN HARGA
                TextEntry::make('base_price')
                    ->label('Harga Service')
                    ->money('IDR'),

                TextEntry::make('pickup_fee')
                    ->label('Biaya Pickup')
                    ->money('IDR'),

                TextEntry::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR'),

                // 📊 STATUS
                TextEntry::make('status')
                    ->label('Status'),

                // 🕒 TIMESTAMP
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime(),
            ]);
    }
}