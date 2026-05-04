<?php

namespace App\Filament\Admin\Resources\Incomes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use App\Models\Payment;

class IncomeForm
{
    public static function configure(): array
    {
        return [
            Select::make('income_type')
                ->label('Tipe Pendapatan')
                ->options([
                    'manual' => 'Manual',
                ])
                ->default('manual')
                ->required(),

            Select::make('payment_id')
                ->label('Referensi Payment (Opsional)')
                ->relationship('payment', 'id')
                ->getOptionLabelFromRecordUsing(
                    fn($record) =>
                    $record->booking->booking_code . ' - Rp ' . number_format($record->amount, 0, ',', '.')
                )
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    if (!$state) return;

                    $payment = Payment::with('booking')->find($state);

                    if ($payment) {
                        $set('amount', $payment->amount);
                        $set('description', 'Manual dari booking ' . $payment->booking->booking_code);
                    }
                }),

            TextInput::make('amount')
                ->label('Jumlah')
                ->numeric()
                ->required()
                ->prefix('Rp'),

            DatePicker::make('income_date')
                ->default(now())
                ->required(),

            TextInput::make('description')
                ->columnSpanFull(),
        ];
    }
}
