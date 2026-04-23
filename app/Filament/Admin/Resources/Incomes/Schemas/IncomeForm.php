<?php

namespace App\Filament\Admin\Resources\Incomes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;

class IncomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 🔗 PAYMENT RELATION
                Select::make('payment_id')
                    ->label('Payment')
                    ->relationship('payment', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) =>
                        $record->booking->booking_code . ' - Rp ' . number_format($record->amount, 0, ',', '.')
                    )
                    ->searchable()
                    ->required(),

                // 💰 AMOUNT
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),

                // 📊 INCOME TYPE
                Select::make('income_type')
                    ->label('Income Type')
                    ->options([
                        'booking' => 'Booking',
                        'other' => 'Other',
                    ])
                    ->default('booking')
                    ->required(),

                    // 📅 DATE FIXED
                DatePicker::make('income_date')
                    ->label('Income Date')
                    ->default(now())
                    ->required(),
                // 📝 DESCRIPTION
                TextInput::make('description')
                    ->label('Description')
                    ->placeholder('Optional')
                    ->columnSpanFull(),
            ]);
    }
}