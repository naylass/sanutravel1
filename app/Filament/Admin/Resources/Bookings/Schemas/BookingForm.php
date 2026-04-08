<?php

namespace App\Filament\Admin\Resources\Bookings\Schemas;

use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_code')
                    ->label('Kode Booking')
                    ->default(fn() => 'BOOK-' . strtoupper(Str::random(8)))
                    ->readOnly()
                    ->unique()
                    ->dehydrated(),
                Select::make('user_id')
                    ->label('Nama')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('service_id')
                    ->label('Layanan')
                    ->options(Service::pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        $service = Service::find($state);
                        $passengers = $get('total_passengers') ?? 1;

                        if ($service?->name === 'Reguler') {
                            $price = 300000 * $passengers;
                        } elseif ($service?->name === 'Eksklusif') {
                            $price = 600000;
                        } else {
                            $price = 0;
                        }

                        $set('price', $price);
                    })
                    ->required(),

                Group::make()
                    ->schema([
                        DatePicker::make('pickup_date')
                            ->label('Tanggal Penjemputan')
                            ->placeholder('Pilih waktu penjemputan'),

                        TimePicker::make('pickup_time')
                            ->label('Waktu Penjemputan')
                            ->placeholder('Pilih waktu penjemputan')
                            ->dehydrated()
                            ->disabled(function (Get $get) {
                                $service = Service::find($get('service_id'));

                                return blank($get('service_id'))
                                    || $service?->name === 'Reguler';
                            })
                            ->belowContent(function (Get $get) {
                                $service = Service::find($get('service_id'));

                                return $service?->name === 'Reguler'
                                    ? 'Layanan Reguler tidak bisa atur waktu penjemputan'
                                    : null;
                            }),

                    ])
                    ->columns(2),

                TextInput::make('phone_number')
                    ->label('Nomor Telepon')
                    ->required(),
                TextInput::make('pickup_location')
                    ->label('Lokasi Penjemputan')
                    ->required(),
                TextInput::make('total_passengers')
                    ->label('Jumlah Penumpang')
                    ->numeric()
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        $service = Service::find($get('service_id'));

                        if ($service?->name === 'Reguler') {
                            $price = 300000 * $state;
                        } elseif ($service?->name === 'Eksklusif') {
                            $price = 600000;
                        } else {
                            $price = 0;
                        }

                        $set('price', $price);
                    })
                    ->required(),
                TextInput::make('destination')
                    ->label('Lokasi Tujuan')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga')
                    ->readOnly()
                    ->prefix('Rp ')
                    ->numeric()
                    ->required(),
            ]);
    }
}
