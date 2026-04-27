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

            // 👨‍✈️ DRIVER
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
                ->preload()
                ->live()
                ->required()
                ->reactive()
                ->disabled(fn(Get $get) => !$get('vehicle_id'))

                ->options(function (Get $get) {

                    $baseId = $get('base_booking_id');
                    $base = $baseId ? Booking::with('service')->find($baseId) : null;

                    $query = Booking::with(['user', 'service'])
                        ->whereNull('schedule_id')
                        ->orderByDesc('id');

                    // 🔥 FILTER BERDASARKAN SERVICE
                    if ($base) {
                        $query->where('service_id', $base->service_id)
                              ->where('pickup_date', $base->pickup_date)
                              ->where('pickup_time', $base->pickup_time)
                              ->where('destination', $base->destination);
                    }

                    return $query->get()->mapWithKeys(function ($b) {
                        return [
                            $b->id =>
                                $b->booking_code
                                . ' | ' . ($b->user?->name ?? '-')
                                . ' | ' . strtoupper($b->service?->name ?? '-') // ✅ FIX
                                . ' | ' . date('d-m', strtotime($b->pickup_date))
                                . ' ' . substr($b->pickup_time, 0, 5)
                                . ' | ' . $b->destination
                                . ' (' . $b->total_passengers . ' org)'
                        ];
                    })->toArray();
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

                    // 🔥 SET BASE
                    if (!$get('base_booking_id')) {
                        $set('base_booking_id', $state[0]);
                    }

                    $baseId = $get('base_booking_id');
                    $base = Booking::with('service')->find($baseId);
                    $bookings = Booking::with('service')->whereIn('id', $state)->get();

                    if (!$base) return;

                    $serviceName = strtolower($base->service->name ?? '');

                    // 🔴 EKSKLUSIF
                    if ($serviceName === 'eksklusif' && count($state) > 1) {
                        Notification::make()
                            ->title('Eksklusif tidak bisa digabung')
                            ->danger()
                            ->send();

                        $set('bookings', [$baseId]);
                        return;
                    }

                    // 🟢 REGULER
                    if ($serviceName === 'reguler') {

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

                    // 🔥 AUTO FILL
                    $set('departure_date', $base->pickup_date);
                    $set('departure_time', $base->pickup_time);
                    $set('destination', $base->destination);

                    $set(
                        'pickup_point',
                        $bookings->pluck('pickup_location')->unique()->join(', ')
                    );

                    // 🔥 CEK KAPASITAS
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
                ->label('Tanggal Keberangkatan')
                ->required(),

            // ⏰
            TimePicker::make('departure_time')
                ->label('Waktu Keberangkatan')
                ->required(),

            // 📍
            TextInput::make('pickup_point')
                ->label('Titik Penjemputan')
                ->readOnly()
                ->required(),

            // 🎯
            TextInput::make('destination')
                ->label('Tujuan')
                ->readOnly()
                ->required(),
        ]);
    }
}