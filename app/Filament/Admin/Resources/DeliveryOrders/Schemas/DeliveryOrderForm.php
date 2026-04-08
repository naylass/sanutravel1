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
                TextInput::make('booking_id')
                    ->label('Booking')
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
                    ->relationship('schedule', 'departure_datetime')
                    ->required(),

                TextInput::make('pickup_point')
                    ->label('Titik Penjemputan')
                    ->required(),

                TextInput::make('destination')
                    ->label('Tujuan')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }
}
