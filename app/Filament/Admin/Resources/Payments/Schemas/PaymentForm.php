<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_id')
                    ->required(),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options(['transfer' => 'Transfer', 'cash' => 'Cash', 'ewallet' => 'Ewallet'])
                    ->required(),
                DateTimePicker::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->required(),
                TextInput::make('amount')
                    ->label('Jumlah Pembayaran')
                    ->required()
                    ->numeric(),
                FileUpload::make('proof_image')
                    ->label('Bukti Pembayaran')
                    ->image(),
                Select::make('status')
                    ->label('Status')
                    ->options(['waiting' => 'Waiting', 'verified' => 'Verified', 'rejected' => 'Rejected'])
                    ->default('waiting')
                    ->required(),
            ]);
    }
}
