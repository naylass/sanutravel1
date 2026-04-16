<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use App\Models\Booking;
use App\Models\Vehicle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('vehicle_id')
                    ->label('Kendaraan')
                    ->relationship('vehicle', 'brand')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $vehicle = Vehicle::find($state);

                        if ($vehicle) {
                            $set('available_seats', $vehicle->capacity);
                        }
                    }),

                Select::make('driver_id')
                    ->label('Sopir')
                    ->relationship('driver', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('booking_id')
                    ->label('Kode Booking')
                    ->options(
                        Booking::with('user', 'service')
                            ->get()
                            ->mapWithKeys(fn($booking) => [
                                $booking->id => $booking->booking_code . ' - ' . ($booking->user->name ?? '-')
                            ])
                    )
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        $booking = Booking::with('service')->find($state);

                        if ($booking) {
                           
                            $set('pickup_point', $booking->pickup_location);
                            $set('destination', $booking->destination);

                           
                            if ($booking->pickup_time) {
                                $set('departure_date', date('Y-m-d', strtotime($booking->pickup_time)));
                                $set('departure_time', date('H:i', strtotime($booking->pickup_time)));
                            }

                            $currentSeats = $booking->total_passengers ?? 1;

                            $availableSeats = $get('available_seats') ?? 0;

                            $set('available_seats', max($availableSeats - $currentSeats, 0));
                        }
                    }),

                DatePicker::make('departure_date')
                    ->label('Tanggal Berangkat')
                    ->required()
                    ->reactive(),

                TimePicker::make('departure_time')
                    ->label('Waktu Berangkat')
                    ->required()
                    ->reactive(),

                TextInput::make('pickup_point')
                    ->label('Titik Penjemputan')
                    ->required(),

                TextInput::make('destination')
                    ->label('Tujuan')
                    ->required(),

                TextInput::make('available_seats')
                    ->label('Kursi Tersedia')
                    ->numeric()
                    ->readOnly()
                    ->required(),
            ]);
    }
}
