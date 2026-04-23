<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use App\Models\Booking;
use App\Models\Vehicle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 🔒 BASE BOOKING (kunci)
            Hidden::make('base_booking_id'),

            // 🚗 KENDARAAN
            Select::make('vehicle_id')
                ->label('Kendaraan')
                ->relationship('vehicle', 'brand')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, Set $set) {
                    $vehicle = Vehicle::find($state);
                    if ($vehicle) {
                        $set('driver_id', $vehicle->driver_id);
                    }
                }),

            // 👨‍✈️ DRIVER (LOCK)
            Select::make('driver_id')
                ->label('Sopir')
                ->relationship('driver', 'name')
                ->disabled()
                ->dehydrated()
                ->required(),

            // 📦 BOOKING
            Select::make('bookings')
                ->label('Pilih Customer')
                ->multiple()
                ->searchable()
                ->required()
                ->reactive()
                ->disabled(fn(Get $get) => !$get('vehicle_id'))

                ->options(function (Get $get) {

                    $baseId = $get('base_booking_id');
                    $base = $baseId ? Booking::find($baseId) : null;

                    $query = Booking::with('user')
                        ->whereNull('schedule_id');

                    // 🔥 FILTER KERAS BERDASARKAN BASE
                    if ($base) {
                        $query->where('pickup_type', $base->pickup_type)
                              ->where('pickup_date', $base->pickup_date)
                              ->where('pickup_time', $base->pickup_time)
                              ->where('destination', $base->destination);
                    }

                    return $query->get()->mapWithKeys(function ($b) {
                        return [
                            $b->id =>
                                $b->booking_code
                                . ' | ' . ($b->user->name ?? '-')
                                . ' | ' . strtoupper($b->pickup_type)
                                . ' | ' . date('d-m', strtotime($b->pickup_date))
                                . ' ' . substr($b->pickup_time, 0, 5)
                                . ' | ' . $b->destination
                                . ' (' . $b->total_passengers . ' org)'
                        ];
                    });
                })

                ->afterStateUpdated(function ($state, Set $set, Get $get) {

                    if (!$get('vehicle_id')) {
                        Notification::make()
                            ->title('Pilih kendaraan dulu')
                            ->warning()
                            ->send();

                        $set('bookings', []);
                        return;
                    }

                    if (empty($state)) {
                        $set('base_booking_id', null);
                        return;
                    }

                    // 🔥 SET BASE (booking pertama)
                    $baseId = $get('base_booking_id');
                    if (!$baseId) {
                        $baseId = $state[0];
                        $set('base_booking_id', $baseId);
                    }

                    $base = Booking::find($baseId);
                    $bookings = Booking::whereIn('id', $state)->get();

                    if (!$base) return;

                    if ($base->pickup_type === 'eksklusif' && count($state) > 1) {
                        Notification::make()
                            ->title('Eksklusif tidak bisa digabung')
                            ->danger()
                            ->send();

                        $set('bookings', [$baseId]);
                        return;
                    }

                    if ($base->pickup_type === 'reguler') {

                        if ($bookings->where('pickup_date', '!=', $base->pickup_date)->count()) {
                            Notification::make()->title('Tanggal beda')->danger()->send();
                            $set('bookings', [$baseId]);
                            return;
                        }

                        if ($bookings->where('pickup_time', '!=', $base->pickup_time)->count()) {
                            Notification::make()->title('Jam beda')->danger()->send();
                            $set('bookings', [$baseId]);
                            return;
                        }

                        if ($bookings->where('destination', '!=', $base->destination)->count()) {
                            Notification::make()->title('Tujuan beda')->danger()->send();
                            $set('bookings', [$baseId]);
                            return;
                        }
                    }

                    $set('departure_date', $base->pickup_date);
                    $set('departure_time', $base->pickup_time);
                    $set('destination', $base->destination);

                    $set(
                        'pickup_point',
                        $bookings->pluck('pickup_location')->unique()->join(', ')
                    );

                    $vehicle = Vehicle::find($get('vehicle_id'));

                    if ($vehicle) {
                        $total = $bookings->sum('total_passengers');

                        if ($total > $vehicle->capacity) {
                            Notification::make()
                                ->title('Kapasitas penuh')
                                ->body("Total: $total / {$vehicle->capacity}")
                                ->danger()
                                ->send();

                            $set('bookings', [$baseId]);
                            return;
                        }
                    }
                }),

            // 📅
            DatePicker::make('departure_date')
                ->required(),

            // ⏰
            TimePicker::make('departure_time')
                ->required(),

            // 📍
            TextInput::make('pickup_point')
                ->readOnly()
                ->required(),

            // 🎯
            TextInput::make('destination')
                ->readOnly()
                ->required(),
        ]);
    }
}