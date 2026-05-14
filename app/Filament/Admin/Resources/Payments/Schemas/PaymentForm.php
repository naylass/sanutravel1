<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use App\Models\Booking;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 🔗 BOOKING RELATION
            Select::make('booking_id')
                ->label('Booking')
                ->relationship('booking', 'booking_code')
                ->searchable()
                ->preload()
                ->reactive()
                ->afterStateUpdated(function ($state, $set) {

                    $booking = Booking::find($state);

                    if ($booking) {
                        $set('amount', $booking->total_price);
                        $set('transfer_info', 'Booking: ' . $booking->booking_code);
                    }
                })
                ->required(),

            // 💳 PAYMENT METHOD
            Select::make('payment_method')
                ->label('Metode Pembayaran')
                ->options([
                    'qris' => 'QRIS',
                    'cash' => 'Cash (Bayar ke Driver)',
                ])
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, $set) {

                    // QRIS → waiting verification
                    if ($state === 'qris') {
                        $set('status', 'waiting_verification');
                    }

                    // CASH → langsung ke driver flow
                    if ($state === 'cash') {
                        $set('status', 'waiting_driver_collection');
                    }
                }),

            TextInput::make('transfer_info')
                ->label('Keterangan')
                ->nullable(),

            // 📸 BUKTI PEMBAYARAN (QRIS ONLY)
            FileUpload::make('payment_proof')
                ->label('Bukti Pembayaran')
                ->image()
                ->directory('payment-proofs')
                ->visible(fn ($get) => $get('payment_method') === 'qris')
                ->nullable(),

            // 💰 AMOUNT
            TextInput::make('amount')
                ->numeric()
                ->readOnly()
                ->required(),

            // 🕒 PAYMENT DATE
            DateTimePicker::make('paid_at')
                ->label('Waktu Bayar')
                ->nullable(),
        ]);
    }
}