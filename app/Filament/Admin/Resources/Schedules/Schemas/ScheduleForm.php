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
                    ->label('Booking')
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
                    ->afterStateUpdated(function ($state, Set $set) {
                        $booking = Booking::with('service')->find($state);

                        if ($booking) {
                            $set('pickup_point', $booking->pickup_location);
                            $set('destination', $booking->destination);

                            $serviceType = $booking->service->type ?? 'regular';

                            if ($serviceType === 'exclusive' && $booking->pickup_time) {
                                $set('departure_date', date('Y-m-d', strtotime($booking->pickup_time)));
                                $set('departure_time', date('H:i:s', strtotime($booking->pickup_time)));
                            } else {
                                $set('departure_date', null);
                                $set('departure_time', null);
                            }

                            $currentSeats = $booking->total_passengers ?? 1;
                            $set('available_seats', function ($get) use ($currentSeats) {
                                return max(($get('available_seats') ?? 0) - $currentSeats, 0);
                            });
                        }
                    }),

                DatePicker::make('departure_date')
                    ->label('Tanggal Berangkat')
                    ->required(),

                TimePicker::make('departure_time')
                    ->label('Waktu Berangkat')
                    ->required()
                    ->reactive()
                    ->disabled(function ($get) {
                        $bookingId = $get('booking_id');
                        if (!$bookingId) return true;

                        $booking = Booking::with('service')->find($bookingId);

                        $serviceType = $booking->service->type ?? 'regular';
                        return $serviceType === 'regular';
                    }),

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
