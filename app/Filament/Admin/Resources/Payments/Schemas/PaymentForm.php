<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use App\Models\Booking;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 📦 BOOKING SELECT (FIXED + SECURE)
            Select::make('booking_id')
                ->label('Booking Transfer')
                ->relationship(
                    name: 'booking',
                    titleAttribute: 'booking_code',
                    modifyQueryUsing: function ($query) {
                        if (!Auth::user()->hasRole('admin')) {
                            $query->where('user_id', Auth::id());
                        }
                    }
                )
                ->getOptionLabelFromRecordUsing(
                    fn($record) =>
                    $record->booking_code .
                        ' - ' . ($record->user?->name ?? '-') .
                        ' [' . strtoupper($record->status ?? '-') . ']'
                )
                ->searchable()
                ->preload()
                ->reactive()

                // auto fill data
                ->afterStateUpdated(function ($state, $set) {

                    $booking = \App\Models\Booking::with('user')->find($state);

                    if ($booking) {
                        $set(
                            'booking_info',
                            'Kode: ' . $booking->booking_code .
                                ' | Customer: ' . ($booking->user->name ?? '-') .
                                ' | Status: ' . ($booking->status ?? '-')
                        );

                        $set('amount', $booking->price);
                    }
                })

                ->required(),

            // 🔍 INFO BOOKING
            TextInput::make('booking_info')
                ->label('Info Booking')
                ->readOnly()
                ->columnSpanFull(),

            // 💳 PAYMENT METHOD
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

                    $set(
                        'status',
                        $state === 'cash' ? 'verified' : 'waiting'
                    );
                }),

            // 🏦 TRANSFER SECTION
            Section::make('Informasi Transfer')
                ->visible(fn($get) => $get('payment_method') === 'transfer')
                ->schema([

                    TextInput::make('bank_name')
                        ->default('BCA')
                        ->readOnly(),

                    TextInput::make('account_number')
                        ->default('1234567890')
                        ->readOnly(),

                    TextInput::make('account_name')
                        ->default('PT SANU TRAVEL')
                        ->readOnly(),

                    FileUpload::make('proof_image')
                        ->image()
                        ->required(fn($get) => $get('payment_method') === 'transfer')
                ]),

            // 📅 DATE
            DateTimePicker::make('payment_date')
                ->required(),

            // 💰 AMOUNT
            TextInput::make('amount')
                ->numeric()
                ->readOnly()
                ->required(),
        ]);
    }
}
