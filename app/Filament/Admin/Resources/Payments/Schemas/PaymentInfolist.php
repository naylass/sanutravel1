<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextEntry::make('booking.booking_code')
                ->label('Kode Booking'),

            TextEntry::make('booking.customer_name')
                ->label('Customer'),

            TextEntry::make('payment_method')
                ->label('Metode')
                ->badge(),

            TextEntry::make('amount')
                ->label('Total')
                ->money('IDR'),

            TextEntry::make('status')
                ->label('Status')
                ->badge(),

            TextEntry::make('paid_at')
                ->label('Paid At')
                ->dateTime('d M Y H:i'),

            TextEntry::make('verified_at')
                ->label('Verified At')
                ->dateTime('d M Y H:i'),

            TextEntry::make('driver_received_at')
                ->label('Driver Receive')
                ->dateTime('d M Y H:i'),

            TextEntry::make('settled_to_admin_at')
                ->label('Settled At')
                ->dateTime('d M Y H:i'),

            // ✅ BUKTI PEMBAYARAN
            ImageEntry::make('payment_proof')
                ->label('Bukti Pembayaran')

                ->getStateUsing(function ($record) {

                    if (!$record->payment_proof) {
                        return null;
                    }

                    return asset('storage/' . $record->payment_proof);
                })

                ->height(250)
        ]);
    }
}
