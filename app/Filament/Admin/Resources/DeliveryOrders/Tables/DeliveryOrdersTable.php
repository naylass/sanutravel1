<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.booking_code')
                    ->label('Booking')
                    ->sortable(),

                TextColumn::make('driver.name')
                    ->label('Sopir')
                    ->sortable(),

                TextColumn::make('vehicle.brand')
                    ->label('Kendaraan')
                    ->sortable(),

                TextColumn::make('schedule.departure_datetime')
                    ->label('Waktu Keberangkatan')
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
            ->headerActions([
                Action::make('generate')
                    ->label('Generate Delivery Order')
                    ->icon(Heroicon::ClipboardDocument)
                    ->form([
                        Select::make('booking_id')
                            ->relationship('booking', 'booking_code')
                            ->required(),
                        Select::make('driver_id')
                            ->relationship('driver', 'name')
                            ->required(),
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}