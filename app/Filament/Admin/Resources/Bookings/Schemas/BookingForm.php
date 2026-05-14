<?php

namespace App\Filament\Admin\Resources\Bookings\Schemas;

use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;


class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([


            TextInput::make('booking_code')
                ->default(fn() => 'BOOK-' . strtoupper(Str::random(8)))
                ->readOnly()
                ->dehydrated(),

            Select::make('service_id')
                ->relationship('service', 'name')
                ->reactive()
                ->required(),

            DatePicker::make('pickup_date')
                ->required(),

            Select::make('pickup_time')
                ->label('Jam (Reguler)')
                ->options([
                    '08:00:00' => '08:00 WIB',
                    '12:00:00' => '12:00 WIB',
                    '15:00:00' => '15:00 WIB',
                    '18:00:00' => '18:00 WIB',
                    '22:00:00' => '22:00 WIB',
                    '00:00:00' => '00:00 WIB',
                    '03:00:00' => '03:00 WIB',
                    '06:00:00' => '06:00 WIB',
                ])
                ->visible(
                    fn(Get $get) =>
                    Service::find($get('service_id'))?->name === 'Reguler'
                )
                ->required(
                    fn(Get $get) =>
                    Service::find($get('service_id'))?->name === 'Reguler'
                ),

            TimePicker::make('pickup_time')
                ->label('Jam (Eksklusif)')
                ->seconds(false)
                ->visible(
                    fn(Get $get) =>
                    Service::find($get('service_id'))?->name === 'Eksklusif'
                )
                ->required(
                    fn(Get $get) =>
                    Service::find($get('service_id'))?->name === 'Eksklusif'
                ),

            TextInput::make('customer_name')
                ->label('Nama Pelanggan')
                ->required(),

            TextInput::make('phone_number')
                ->label('No. Telepon')
                ->required(),

            TextInput::make('pickup_location')
                ->required(),

            TextInput::make('destination')
                ->required(),

            TextInput::make('total_passengers')
                ->numeric()
                ->minValue(1)
                ->reactive()
                ->required(),

            Select::make('pickup_area')
                ->options([
                    'Cilegon' => 'Cilegon',
                    'Serang' => 'Serang',
                    'Luar Wilayah' => 'Luar Wilayah',
                ])
                ->required(),

            TextInput::make('total_price')
                ->readOnly()
                ->prefix('Rp')
                ->numeric(),

            Select::make('payment_method')
                ->options([
                    'qris' => 'QRIS',
                    'cash' => 'Cash (Bayar ke Driver)',
                ])
                ->required(),
        ]);
    }

    private static function calculatePrice(Get $get): int
    {
        $service = Service::find($get('service_id'));
        $passengers = $get('total_passengers') ?? 1;

        $basePrice = match ($service?->name) {
            'Reguler' => 300000 * $passengers,
            'Eksklusif' => 600000,
            default => 0,
        };

        $pickupFee = match ($get('pickup_area')) {
            'Luar Wilayah' => 50000,
            default => 0,
        };

        return $basePrice + $pickupFee;
    }
}
