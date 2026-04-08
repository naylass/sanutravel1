<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\RelationshipColumn; // Use this for related columns
use Filament\Tables\Table;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_id')
                    ->label('Booking')
                    ->relationship('booking', 'booking_code') 
                    ->sortable(),

                TextColumn::make('driver_id')
                    ->label('Sopir')
                    ->relationship('driver', 'name') 
                    ->sortable(),

                TextColumn::make('vehicle_id')
                    ->label('Kendaraan')
                    ->relationship('vehicle', 'brand') 
                    ->sortable(),
            
                TextColumn::make('schedule_id')
                    ->label('Waktu Keberangkatan')
                    ->relationship('schedule', 'departure_datetime') 
                    ->dateTime('d M Y H:i')  
                    ->sortable(),
                
                TextColumn::make('pickup_point')
                    ->label('Titik Penjemputan')
                    ->sortable(),
            
                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([ 

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