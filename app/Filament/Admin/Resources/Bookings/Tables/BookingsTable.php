<?php

namespace App\Filament\Admin\Resources\Bookings\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{


    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-clipboard')
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold')
                    ->description(fn($record) => $record->phone_number),

                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->badge()
                    ->icon(
                        fn($state) => $state === 'Eksklusif'
                        ? 'heroicon-o-star'
                        : 'heroicon-o-user-group'
                    )
                    ->color(
                        fn($state) => $state === 'Eksklusif'
                        ? 'success'
                        : 'gray'
                    ),

                TextColumn::make('pickup_location')
                    ->label('Perjalanan')
                    ->icon('heroicon-o-map-pin')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->pickup_location . '  → ' . $record->destination
                    )
                    ->limit(35)
                    ->tooltip(
                        fn($record) =>
                        $record->pickup_location . ' → ' . $record->destination
                    ),

                TextColumn::make('total_passengers')
                    ->label('Pax')
                    ->badge()
                    ->alignCenter()
                    ->icon('heroicon-o-users')
                    ->color('info'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->icon('heroicon-o-banknotes')
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('pickup_date')
                    ->label('Tanggal Jemput')
                    ->icon('heroicon-o-clock')
                    ->placeholder('-'),

                TextColumn::make('pickup_time')
                    ->label('Waktu Jemput')
                    ->icon('heroicon-o-clock')
                    ->placeholder('-'),

                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->icon(
                        fn($state) => $state === 'paid'
                        ? 'heroicon-o-check-circle'
                        : 'heroicon-o-x-circle'
                    )
                    ->color(
                        fn($state) => $state === 'paid'
                        ? 'success'
                        : 'danger'
                    ),


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
                    ViewAction::make()->icon('heroicon-o-eye'),
                    EditAction::make()->icon('heroicon-o-pencil'),
                    DeleteAction::make()->icon('heroicon-o-trash'),
                ])
            ])

            ->striped()
            ->paginated([10, 25, 50]);
    }
}
;
