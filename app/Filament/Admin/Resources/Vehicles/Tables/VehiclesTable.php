<?php

namespace App\Filament\Admin\Resources\Vehicles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plate_number')
                    ->label('Nomor Polisi')
                    ->searchable(),

                TextColumn::make('brand')
                    ->label('Merk Kendaraan')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Tipe Kendaraan')
                    ->searchable(),

                TextColumn::make('capacity')
                    ->label('Kapasitas Kursi')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status Kendaraan')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'available' => 'Available',
                        'on_trip' => 'On Trip',
                        default => 'Unknown',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
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