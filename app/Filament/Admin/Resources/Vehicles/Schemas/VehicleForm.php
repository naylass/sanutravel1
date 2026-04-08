<?php

namespace App\Filament\Admin\Resources\Vehicles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('plate_number')
                    ->label('Nomor Polisi')
                    ->required(),

                TextInput::make('brand')
                    ->label('Merk Kendaraan')
                    ->required(),

                TextInput::make('type')
                    ->label('Tipe Kendaraan')
                    ->required(),

                TextInput::make('capacity')
                    ->label('Kapasitas Kursi')
                    ->required()
                    ->numeric()
                    ->minValue(1),

                Select::make('status')
                    ->label('Status Kendaraan')
                    ->options([
                        'available' => 'Available',
                        'on_trip' => 'On trip',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }
}