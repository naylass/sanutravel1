<?php

namespace App\Filament\Admin\Resources\Bookings\Schemas;

use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 🔢 KODE BOOKING
                TextInput::make('booking_code')
                    ->label('Kode Booking')
                    ->default(fn() => 'BOOK-' . strtoupper(Str::random(8)))
                    ->readOnly()
                    ->unique()
                    ->dehydrated(),

                // 👤 NAMA CUSTOMER (AUTO)
                TextInput::make('user_name')
                    ->label('Nama Customer')
                    ->default(fn() => Auth::user()?->name)
                    ->readOnly(),

                // 🔒 USER ID (HIDDEN)
                Hidden::make('user_id')
                    ->default(fn() => Auth::id())
                    ->dehydrated()
                    ->required(),

                // 🚘 LAYANAN
                Select::make('service_id')
                    ->label('Layanan')
                    ->relationship('service', 'name')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {

                        $service = Service::find($state);

                        // 🔥 SET TIPE
                        if ($service?->name === 'Reguler') {
                            $set('pickup_type', 'reguler');
                        } elseif ($service?->name === 'Eksklusif') {
                            $set('pickup_type', 'eksklusif');
                        }

                        // 🔥 HITUNG HARGA
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

                // 🔒 TIPE PICKUP
                Select::make('pickup_type')
                    ->options([
                        'reguler' => 'Reguler',
                        'eksklusif' => 'Eksklusif',
                    ])
                    ->hidden()
                    ->dehydrated()
                    ->required(),

                // 📅 & ⏰
                Group::make()
                    ->schema([

                        DatePicker::make('pickup_date')
                            ->label('Tanggal Penjemputan')
                            ->required(),

                        // REGULER
                        Select::make('pickup_time')
                            ->label('Jam Reguler')
                            ->options([
                                '08:00:00' => '08:00 WIB',
                                '12:00:00' => '12:00 WIB',
                                '15:00:00' => '15:00 WIB',
                                '18:00:00' => '18:00 WIB',
                                '21:00:00' => '21:00 WIB',
                                '00:00:00' => '00:00 WIB',
                                '03:00:00' => '03:00 WIB',
                            ])
                            ->visible(fn(Get $get) => $get('pickup_type') === 'reguler')
                            ->required(fn(Get $get) => $get('pickup_type') === 'reguler'),

                        // EKSKLUSIF
                        TimePicker::make('pickup_time')
                            ->label('Jam Eksklusif')
                            ->seconds(false)
                            ->visible(fn(Get $get) => $get('pickup_type') === 'eksklusif')
                            ->required(fn(Get $get) => $get('pickup_type') === 'eksklusif'),

                    ])
                    ->columns(2),

                // 📞
                TextInput::make('phone_number')
                    ->label('Nomor Telepon')
                    ->required(),

                // 📍
                TextInput::make('pickup_location')
                    ->label('Lokasi Penjemputan')
                    ->required(),

                // 👥
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

                // 🎯
                TextInput::make('destination')
                    ->label('Lokasi Tujuan')
                    ->required(),

                // 💰
                TextInput::make('price')
                    ->label('Harga')
                    ->readOnly()
                    ->prefix('Rp ')
                    ->numeric()
                    ->required(),
            ]);
    }
}