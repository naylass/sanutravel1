<?php

namespace App\Filament\Admin\Resources\Incomes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class IncomeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 🎫 BOOKING SAFE
            TextEntry::make('payment.booking.booking_code')
                ->label('Kode Booking')
                ->formatStateUsing(fn ($record) =>
                    $record->payment?->booking?->booking_code ?? '-'
                ),

            // 💰 AMOUNT
            TextEntry::make('amount')
                ->label('Jumlah')
                ->money('IDR'),

            // 📊 TYPE
            TextEntry::make('income_type')
                ->label('Tipe')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'booking' => 'success',
                    'manual' => 'warning',
                    default => 'gray',
                }),

            // 📝 DESC
            TextEntry::make('description')
                ->label('Deskripsi')
                ->placeholder('-'),

            // 📅 DATE
            TextEntry::make('income_date')
                ->label('Tanggal')
                ->date(),

            // 🕒 CREATED
            TextEntry::make('created_at')
                ->label('Dibuat')
                ->dateTime(),

            // 🕒 UPDATED
            TextEntry::make('updated_at')
                ->label('Update')
                ->dateTime(),
        ]);
    }
}