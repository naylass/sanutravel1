<?php

namespace App\Filament\Admin\Resources\Bookings\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // Booking Code
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-clipboard')
                    ->weight('bold'),

                // User
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold')
                    ->description(fn($record) => $record->phone_number),

                // Service + Pickup Type
                TextColumn::make('pickup_type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->icon(fn($state) => $state === 'eksklusif'
                        ? 'heroicon-o-star'
                        : 'heroicon-o-user-group'
                    )
                    ->color(fn($state) => $state === 'eksklusif'
                        ? 'success'
                        : 'gray'
                    ),

                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->sortable()
                    ->toggleable(),

                // Route
                TextColumn::make('route')
                    ->label('Perjalanan')
                    ->icon('heroicon-o-map-pin')
                    ->getStateUsing(fn($record) =>
                        $record->pickup_location . ' → ' . $record->destination
                    )
                    ->limit(35)
                    ->tooltip(fn($record) =>
                        $record->pickup_location . ' → ' . $record->destination
                    ),

                // Passengers
                TextColumn::make('total_passengers')
                    ->label('Pax')
                    ->badge()
                    ->alignCenter()
                    ->icon('heroicon-o-users')
                    ->color('info'),

                // Price
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->icon('heroicon-o-banknotes')
                    ->weight('bold')
                    ->color('success'),

                // Pickup Date
                TextColumn::make('pickup_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),

                // Pickup Time (with format)
                TextColumn::make('pickup_time')
                    ->label('Waktu')
                    ->time('H:i')
                    ->icon('heroicon-o-clock'),

                // Payment Status
                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->icon(fn($state) => $state === 'paid'
                        ? 'heroicon-o-check-circle'
                        : 'heroicon-o-x-circle'
                    )
                    ->color(fn($state) => $state === 'paid'
                        ? 'success'
                        : 'danger'
                    ),

                // Booking Status
                TextColumn::make('status')
                    ->badge()
                    ->icon(fn($state) => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'confirmed' => 'heroicon-o-check',
                        'completed' => 'heroicon-o-check-badge',
                        'cancelled' => 'heroicon-o-x-circle',
                    })
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
            ])

            ->defaultSort('created_at', 'desc')

            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])

            ->striped()
            ->paginated([10, 25, 50]);
    }
}