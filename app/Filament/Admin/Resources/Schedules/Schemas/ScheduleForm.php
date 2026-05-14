<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use App\Models\Booking;
use App\Models\Vehicle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | HIDDEN
            |--------------------------------------------------------------------------
            */

            Hidden::make('base_booking_id'),

            /*
            |--------------------------------------------------------------------------
            | BOOKING
            |--------------------------------------------------------------------------
            */

            Select::make('bookings')

                ->label('Pilih Customer')

                ->multiple()

                ->searchable()

                ->preload()

                ->reactive()

                ->relationship(
                    name: 'bookings',
                    titleAttribute: 'booking_code'
                )

                ->getOptionLabelFromRecordUsing(
                    fn($record) =>

                    $record->booking_code .
                        ' | ' .
                        $record->customer_name .
                        ' | ' .
                        strtoupper($record->service?->name ?? '-') .
                        ' | ' .
                        $record->destination .
                        ' | ' .
                        $record->total_passengers . ' pax'
                )

                ->afterStateUpdated(function (
                    $state,
                    Set $set,
                    Get $get
                ) {

                    if (!$state || count($state) === 0) {
                        return;
                    }

                    $bookings = Booking::with('service')
                        ->whereIn('id', $state)
                        ->get();

                    $base = $bookings->first();

                    if (!$base) {
                        return;
                    }

                    $serviceName =
                        strtolower($base->service?->name ?? '');

                    /*
                    |--------------------------------------------------------------------------
                    | EKSKLUSIF
                    |--------------------------------------------------------------------------
                    */

                    if ($serviceName === 'eksklusif') {

                        if (count($bookings) > 1) {

                            Notification::make()
                                ->title('Booking Eksklusif tidak bisa digabung')
                                ->body('1 booking eksklusif = 1 schedule')
                                ->danger()
                                ->send();

                            $set('bookings', [$base->id]);

                            return;
                        }

                        $set(
                            'departure_date',
                            $base->pickup_date
                        );

                        $set(
                            'departure_time',
                            $base->pickup_time
                        );

                        $set(
                            'destination',
                            $base->destination
                        );

                        $set(
                            'pickup_location',
                            $base->pickup_location
                        );

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | REGULER VALIDATION
                    |--------------------------------------------------------------------------
                    */

                    foreach ($bookings as $booking) {

                        $bookingService =
                            strtolower(
                                $booking->service?->name ?? ''
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | TIDAK BOLEH CAMPUR EKSKLUSIF
                        |--------------------------------------------------------------------------
                        */

                        if ($bookingService !== 'reguler') {

                            Notification::make()
                                ->title('Reguler tidak boleh dicampur eksklusif')
                                ->danger()
                                ->send();

                            $set('bookings', [$base->id]);

                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL HARUS SAMA
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $booking->pickup_date !=
                            $base->pickup_date
                        ) {

                            Notification::make()
                                ->title('Tanggal keberangkatan harus sama')
                                ->danger()
                                ->send();

                            $set('bookings', [$base->id]);

                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | JAM HARUS SAMA
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $booking->pickup_time !=
                            $base->pickup_time
                        ) {

                            Notification::make()
                                ->title('Jam keberangkatan harus sama')
                                ->danger()
                                ->send();

                            $set('bookings', [$base->id]);

                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | TUJUAN HARUS SAMA
                        |--------------------------------------------------------------------------
                        */

                        if (
                            strtolower($booking->destination)
                            != strtolower($base->destination)
                        ) {

                            Notification::make()
                                ->title('Tujuan harus sama')
                                ->danger()
                                ->send();

                            $set('bookings', [$base->id]);

                            return;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI KAPASITAS
                    |--------------------------------------------------------------------------
                    */

                    $vehicle =
                        Vehicle::find($get('vehicle_id'));

                    if ($vehicle) {

                        $totalPassengers =
                            $bookings->sum('total_passengers');

                        if (
                            $totalPassengers >
                            $vehicle->capacity
                        ) {

                            Notification::make()
                                ->title('Kapasitas kendaraan penuh')
                                ->body(
                                    'Total penumpang: ' .
                                        $totalPassengers .
                                        ' / ' .
                                        $vehicle->capacity
                                )
                                ->danger()
                                ->send();

                            return;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | AUTO FILL
                    |--------------------------------------------------------------------------
                    */

                    $set(
                        'departure_date',
                        $base->pickup_date
                    );

                    $set(
                        'departure_time',
                        $base->pickup_time
                    );

                    $set(
                        'destination',
                        $base->destination
                    );

                    $set(
                        'pickup_location',
                        $bookings
                            ->pluck('pickup_location')
                            ->unique()
                            ->implode(', ')
                    );
                }),

            /*
            |--------------------------------------------------------------------------
            | VEHICLE
            |--------------------------------------------------------------------------
            */

            Select::make('vehicle_id')

                ->label('Kendaraan')

                ->relationship('vehicle', 'brand')

                ->searchable()

                ->preload()

                ->reactive()

                ->required()

                ->afterStateUpdated(function (
                    $state,
                    Set $set,
                    Get $get
                ) {

                    $vehicle =
                        Vehicle::with('driver')
                        ->find($state);

                    /*
                    |--------------------------------------------------------------------------
                    | AUTO FILL DRIVER
                    |--------------------------------------------------------------------------
                    */

                    if ($vehicle) {

                        $set(
                            'driver_id',
                            $vehicle->driver_id
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI KAPASITAS SAAT GANTI MOBIL
                    |--------------------------------------------------------------------------
                    */

                    $bookingIds =
                        $get('bookings') ?? [];

                    $bookings = Booking::whereIn(
                        'id',
                        $bookingIds
                    )->get();

                    if (
                        $vehicle &&
                        $bookings->count()
                    ) {

                        $totalPassengers =
                            $bookings->sum(
                                'total_passengers'
                            );

                        if (
                            $totalPassengers >
                            $vehicle->capacity
                        ) {

                            Notification::make()
                                ->title('Kapasitas kendaraan tidak cukup')
                                ->body(
                                    'Total penumpang: ' .
                                        $totalPassengers .
                                        ' / ' .
                                        $vehicle->capacity
                                )
                                ->danger()
                                ->send();
                        }
                    }
                }),

            /*
            |--------------------------------------------------------------------------
            | DRIVER
            |--------------------------------------------------------------------------
            */

            Select::make('driver_id')

                ->label('Sopir')

                ->relationship('driver', 'name')

                ->searchable()

                ->disabled()

                ->dehydrated()

                ->required(),

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            DatePicker::make('departure_date')

                ->label('Tanggal Berangkat')
                ->readOnly()

                ->required(),

            /*
            |--------------------------------------------------------------------------
            | TIME
            |--------------------------------------------------------------------------
            */

            TimePicker::make('departure_time')

                ->label('Jam Berangkat')
                ->readOnly()

                ->required(),

            /*
            |--------------------------------------------------------------------------
            | PICKUP
            |--------------------------------------------------------------------------
            */

            TextInput::make('pickup_location')

                ->label('Lokasi Penjemputan')

                ->readOnly()

                ->required(),

            /*
            |--------------------------------------------------------------------------
            | DESTINATION
            |--------------------------------------------------------------------------
            */

            TextInput::make('destination')

                ->label('Tujuan')

                ->readOnly()

                ->required(),
        ]);
    }
}
