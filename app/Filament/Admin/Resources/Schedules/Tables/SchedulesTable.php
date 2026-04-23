<?php

namespace App\Filament\Admin\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driver.name')
                    ->label('Sopir')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vehicle.brand')
                    ->label('Kendaraan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('bookings.booking_code')
                    ->label('Kode Booking')
                    ->badge()
                    ->separator(', '),

                TextColumn::make('bookings.user.name')
                    ->label('Nama Pemesan')
                    ->badge()
                    ->separator(', '),

                TextColumn::make('departure_date')
                    ->label('Tanggal Keberangkatan')
                    ->date()
                    ->sortable(),

                TextColumn::make('departure_time')
                    ->label('Waktu Keberangkatan')
                    ->time()
                    ->sortable(),

                TextColumn::make('pickup_point')
                    ->label('Titik Penjemputan')
                    ->searchable(),

                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->searchable(),

                TextColumn::make('available_seats')
                    ->label('Kursi Tersedia')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
