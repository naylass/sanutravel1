<?php

namespace App\Filament\Admin\Resources\Bookings\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // 🔢 BOOKING CODE
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                // 👤 CUSTOMER
                TextColumn::make('customer_name')
                    ->label('Nama Customer')
                    ->searchable(),

                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->badge(),

                // 📍 PICKUP AREA
                TextColumn::make('area')
                    ->label('Area')
                    ->badge(),

                // 📍 RUTE
                TextColumn::make('pickup_location')
                    ->label('Alamat Jemput'),

                TextColumn::make('pickup_date')
                    ->date()
                    ->label('Tanggal'),

                TextColumn::make('pickup_time')
                    ->label('Jam'),

                TextColumn::make('destination')
                    ->label('Tujuan'),

                TextColumn::make('total_passengers')
                    ->label('Pax')
                    ->badge(),

                TextColumn::make('base_price')
                    ->money('IDR')
                    ->label('Base'),

                TextColumn::make('pickup_fee')
                    ->money('IDR')
                    ->label('Fee'),

                TextColumn::make('total_price')
                    ->money('IDR')
                    ->label('Total'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'scheduled' => 'Terjadwal',
                        'on_progress' => 'Perjalanan',
                        'completed' => 'Selesai',
                        'cancel_request' => 'Request Cancel',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'scheduled' => 'info',
                        'on_progress' => 'primary',
                        'completed' => 'success',
                        'cancel_request' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->recordActions([

                ActionGroup::make([

                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                        ->visible(fn() => auth()->user()?->hasRole('admin')),

                    Action::make('approve_cancel')
                        ->label('Approve Cancel')
                        ->color('success')
                        ->visible(
                            fn($record) =>
                            $record->status === 'cancel_request'
                        )
                        ->requiresConfirmation()
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'cancelled'
                            ]);

                            Notification::make()
                                ->title('Booking dibatalkan')
                                ->success()
                                ->send();
                        }),

                    Action::make('reject_cancel')
                        ->label('Reject Cancel')
                        ->color('danger')
                        ->visible(
                            fn($record) =>
                            $record->status === 'cancel_request'
                        )
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'confirmed'
                            ]);

                            Notification::make()
                                ->title('Cancel ditolak')
                                ->warning()
                                ->send();
                        }),
                ])
            ])

            ->striped()
            ->paginated([10, 25, 50]);
    }
}
