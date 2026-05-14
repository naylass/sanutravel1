<?php

namespace App\Filament\Admin\Resources\Schedules\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Str;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driver.name')
                    ->label('Nama Sopir')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold'),

                TextColumn::make('vehicle.brand')
                    ->label('Kendaraan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-truck'),

                TextColumn::make('bookings.booking_code')
                    ->label('Kode Booking')
                    ->badge()
                    ->formatStateUsing(function ($record) {

                        return $record->bookings
                            ->pluck('booking_code')
                            ->implode(', ');
                    }),

                TextColumn::make('bookings.customer_name')
                    ->label('Nama Pelanggan')
                    ->icon('heroicon-o-users')
                    ->formatStateUsing(function ($record) {

                        $names = $record->bookings
                            ->pluck('customer_name')
                            ->filter()
                            ->unique();

                        if ($record->bookings->count() === 1) {
                            return $names->first() ?? '-';
                        }

                        return $names->implode(', ');
                    })
                    ->wrap(),

                TextColumn::make('bookings.phone_number')
                    ->label('No HP')
                    ->icon('heroicon-o-phone')
                    ->formatStateUsing(function ($record) {

                        return $record->bookings
                            ->pluck('phone_number')
                            ->filter()
                            ->unique()
                            ->implode(', ');
                    }),

                TextColumn::make('pickup_location')
                    ->label('Rute')
                    ->icon('heroicon-o-map')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->pickup_location . ' → ' . $record->destination
                    )
                    ->wrap(),

                TextColumn::make('departure_date')
                    ->label('Jadwal')
                    ->icon('heroicon-o-clock')
                    ->formatStateUsing(
                        fn($record) =>
                        \Carbon\Carbon::parse(
                            $record->departure_date . ' ' . $record->departure_time
                        )->format('d M Y H:i')
                    ),

                TextColumn::make('bookings.total_passengers')
                    ->label('Pax')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->bookings->sum('total_passengers') . ' orang'
                    ),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(function ($record) {

                        $booking = $record->bookings->first();

                        return ucfirst(
                            strtolower(
                                $booking?->service?->name ?? '-'
                            )
                        );
                    })
                    ->color(function ($record) {

                        $booking = $record->bookings->first();

                        $service = strtolower(
                            $booking?->service?->name ?? ''
                        );

                        return $service === 'reguler'
                            ? 'success'
                            : 'warning';
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])

            ->striped()
            ->paginated([10, 25, 50])
            ->defaultSort('created_at', 'desc');
    }
}
