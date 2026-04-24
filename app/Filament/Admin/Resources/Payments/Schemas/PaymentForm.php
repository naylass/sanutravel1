<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use App\Models\Booking;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 📦 PILIH BOOKING
            Select::make('booking_id')
                ->label('Booking Transfer')
                ->relationship('booking', 'booking_code')
                ->getOptionLabelFromRecordUsing(
                    fn($record) =>
                    $record->booking_code . ' - ' . ($record->user?->name ?? '-')
                )
                ->searchable(['booking_code', 'user.name'])
                ->preload()
                ->reactive()

                ->getOptionLabelFromRecordUsing(
                    fn($record) =>
                    $record->booking_code .
                        ' - ' . ($record->user?->name ?? '-') .
                        ' [' . strtoupper($record->status ?? '-') . ']'
                )
                ->afterStateUpdated(function ($state, $set) {

                    $booking = \App\Models\Booking::with('user')->find($state);

                    if ($booking) {
                        // INFO BOOKING
                        $set(
                            'booking_info',
                            'Kode: ' . $booking->booking_code .
                                ' | Customer: ' . ($booking->user->name ?? '-') .
                                ' | Status: ' . ($booking->status ?? '-')
                        );

                        // TOTAL HARGA
                        $set('amount', $booking->price);
                    }
                })
                ->required(),

            // 🔍 INFO BOOKING
            TextInput::make('booking_info')
                ->label('Info Booking')
                ->readOnly()
                ->columnSpanFull(),

            // 💳 METODE PEMBAYARAN
            Select::make('payment_method')
                ->label('Metode Pembayaran')
                ->options([
                    'transfer' => 'Transfer',
                    'cash' => 'Cash',
                    'ewallet' => 'E-Wallet'
                ])
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, $set) {

                    if ($state === 'cash') {
                        $set('status', 'verified');
                    }

                    if ($state === 'transfer') {
                        $set('status', 'waiting');
                    }
                }),

            // 🏦 SECTION TRANSFER (MUNCUL HANYA SAAT TRANSFER)
            Section::make('Informasi Transfer')
                ->visible(fn($get) => $get('payment_method') === 'transfer')
                ->schema([

                    TextInput::make('bank_name')
                        ->label('Bank')
                        ->default('BCA')
                        ->readOnly(),

                    TextInput::make('account_number')
                        ->label('No Rekening')
                        ->default('1234567890')
                        ->readOnly(),

                    TextInput::make('account_name')
                        ->label('Atas Nama')
                        ->default('PT SANU TRAVEL')
                        ->readOnly(),

                    FileUpload::make('proof_image')
                        ->label('Bukti Transfer')
                        ->image()
                        ->visible(fn($get) => $get('payment_method') === 'transfer')
                        ->required(fn($get) => $get('payment_method') === 'transfer')
                ]),

            // 📅 TANGGAL
            DateTimePicker::make('payment_date')
                ->label('Tanggal Pembayaran')
                ->required(),

            // 💰 JUMLAH
            TextInput::make('amount')
                ->label('Total Pembayaran')
                ->numeric()
                ->readOnly()
                ->required(),
        ]);
    }
}
