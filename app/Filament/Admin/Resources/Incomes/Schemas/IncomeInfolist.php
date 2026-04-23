<?php

namespace App\Filament\Admin\Resources\Incomes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class IncomeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 🎫 BOOKING VIA PAYMENT
                TextEntry::make('payment.booking.booking_code')
                    ->label('Kode Booking'),

                // 💰 JUMLAH INCOME
                TextEntry::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),

                // 📊 TIPE INCOME
                TextEntry::make('income_type')
                    ->label('Tipe Income')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'booking' => 'success',
                        'other' => 'warning',
                        default => 'gray',
                    }),

                // 📝 DESKRIPSI
                TextEntry::make('description')
                    ->label('Deskripsi')
                    ->placeholder('-'),

                // 📅 TANGGAL INCOME
                TextEntry::make('income_date')
                    ->label('Tanggal Income')
                    ->date(),

                // 📅 CREATED AT
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),

                // 📅 UPDATED AT
                TextEntry::make('updated_at')
                    ->label('Update')
                    ->dateTime(),
            ]);
    }
}