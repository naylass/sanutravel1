<?php

namespace App\Filament\Admin\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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

                TextColumn::make('booking.booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('booking.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('departure_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('departure_time')
                    ->time()
                    ->sortable(),

                TextColumn::make('pickup_point')
                    ->searchable(),

                TextColumn::make('destination')
                    ->searchable(),

                TextColumn::make('available_seats')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
