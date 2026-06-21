<?php

namespace App\Filament\Admin\Resources\Schedules\Tables;

use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | DRIVER
                |--------------------------------------------------------------------------
                */

                TextColumn::make('driver.name')

                    ->label('Sopir')

                    ->searchable()

                    ->sortable()

                    ->icon('heroicon-o-user')

                    ->weight('bold')

                    ->color('primary')

                    ->badge(),

                /*
                |--------------------------------------------------------------------------
                | VEHICLE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('vehicle.brand')

                    ->label('Kendaraan')

                    ->searchable()

                    ->sortable()

                    ->icon('heroicon-o-truck')

                    ->weight('semiBold')

                    ->description(fn ($record) =>
                        'Plat: ' .
                        ($record->vehicle?->plate_number ?? '-')
                    ),

                /*
                |--------------------------------------------------------------------------
                | BOOKING CODE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('booking_codes')

                    ->label('Kode Booking')

                    ->badge()

                    ->color('gray')

                    ->searchable()

                    ->wrap()

                    ->state(function ($record) {

                        return $record->bookings
                            ->pluck('booking_code')
                            ->implode(', ');
                    }),

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER
                |--------------------------------------------------------------------------
                */

                TextColumn::make('customers')

                    ->label('Customer')

                    ->icon('heroicon-o-users')

                    ->wrap()

                    ->searchable()

                    ->state(function ($record) {

                        $customers = $record->bookings
                            ->pluck('customer_name')
                            ->filter()
                            ->unique();

                        return $customers->implode(', ');
                    })

                    ->description(function ($record) {

                        $phones = $record->bookings
                            ->pluck('phone_number')
                            ->filter()
                            ->unique()
                            ->implode(', ');

                        return $phones ?: '-';
                    }),

                /*
                |--------------------------------------------------------------------------
                | ROUTE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('route')

                    ->label('Rute Perjalanan')

                    ->icon('heroicon-o-map-pin')

                    ->wrap()

                    ->state(fn ($record) =>

                        $record->pickup_location .
                        ' → ' .
                        $record->destination
                    )

                    ->description(function ($record) {

                        return 'Tujuan: ' .
                            ($record->destination ?? '-');
                    }),

                /*
                |--------------------------------------------------------------------------
                | SCHEDULE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('schedule')

                    ->label('Jadwal')

                    ->icon('heroicon-o-clock')

                    ->badge()

                    ->color('info')

                    ->state(function ($record) {

                        return Carbon::parse(
                            $record->departure_date .
                                ' ' .
                                $record->departure_time
                        )->translatedFormat('d M Y • H:i');
                    }),

                /*
                |--------------------------------------------------------------------------
                | PASSENGER
                |--------------------------------------------------------------------------
                */

                TextColumn::make('passengers')

                    ->label('Penumpang')

                    ->badge()

                    ->color('primary')

                    ->icon('heroicon-o-user-group')

                    ->state(function ($record) {

                        $totalPassengers = $record->bookings
                            ->sum('total_passengers');

                        return $totalPassengers . ' Orang';
                    }),

                /*
                |--------------------------------------------------------------------------
                | REMAINING SEAT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('remaining_seat')

                    ->label('Sisa Kursi')

                    ->badge()

                    ->state(function ($record) {

                        $capacity =
                            $record->vehicle?->capacity ?? 0;

                        $used =
                            $record->bookings
                            ->sum('total_passengers');

                        $remaining =
                            $capacity - $used;

                        return $remaining .
                            ' / ' .
                            $capacity;
                    })

                    ->color(function ($record) {

                        $capacity =
                            $record->vehicle?->capacity ?? 0;

                        $used =
                            $record->bookings
                            ->sum('total_passengers');

                        $remaining =
                            $capacity - $used;

                        if ($remaining <= 0) {
                            return 'danger';
                        }

                        if ($remaining <= 2) {
                            return 'warning';
                        }

                        return 'success';
                    }),

                /*
                |--------------------------------------------------------------------------
                | TYPE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('type')

                    ->label('Tipe')

                    ->badge()

                    ->icon(function ($record) {

                        $service = strtolower(
                            $record->bookings
                                ->first()?->service?->name ?? ''
                        );

                        return $service === 'eksklusif'
                            ? 'heroicon-o-star'
                            : 'heroicon-o-users';
                    })

                    ->state(function ($record) {

                        $service = strtolower(
                            $record->bookings
                                ->first()?->service?->name ?? ''
                        );

                        return ucfirst($service);
                    })

                    ->color(function ($record) {

                        $service = strtolower(
                            $record->bookings
                                ->first()?->service?->name ?? ''
                        );

                        return $service === 'eksklusif'
                            ? 'warning'
                            : 'success';
                    }),

                /*
                |--------------------------------------------------------------------------
                | CREATED
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')

                    ->label('Dibuat')

                    ->since()

                    ->sortable()

                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->recordActions([

                ActionGroup::make([

                    ViewAction::make()

                        ->color('info'),

                    /*
                    |--------------------------------------------------------------------------
                    | EDIT
                    |--------------------------------------------------------------------------
                    */

                    EditAction::make()

                        ->color('warning')

                        ->visible(function ($record) {

                            $service = strtolower(
                                $record->bookings
                                    ->first()?->service?->name ?? ''
                            );

                            // Eksklusif dikunci
                            return $service !== 'eksklusif';
                        }),

                    /*
                    |--------------------------------------------------------------------------
                    | DELETE
                    |--------------------------------------------------------------------------
                    */

                    DeleteAction::make()

                        ->color('danger'),

                ])
            ])

            ->striped()

            ->defaultSort('created_at', 'desc')

            ->paginated([10, 25, 50])

            ->emptyStateHeading('Belum ada schedule')

            ->emptyStateDescription(
                'Schedule travel akan muncul di sini.'
            );
    }
}