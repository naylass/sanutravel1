<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class DeliveryOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->label('Kode Booking')
                    ->relationship('booking', 'booking_code')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('driver_id')
                    ->label('Sopir')
                    ->relationship('driver', 'name')
                    ->required(),

                Select::make('vehicle_id')
                    ->label('Kendaraan')
                    ->relationship('vehicle', 'brand')
                    ->required(),

                Select::make('schedule_id')
                    ->label('Waktu Keberangkatan')
                    ->relationship('schedule', 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        \Carbon\Carbon::parse($record->departure_date . ' ' . $record->departure_time)
                            ->format('d M Y H:i')
                    )
                    ->required(),

                TextInput::make('pickup_point')
                    ->label('Titik Penjemputan')
                    ->required(),

                TextInput::make('destination')
                    ->label('Tujuan')
                    ->required(),
            ]);
    }
}
