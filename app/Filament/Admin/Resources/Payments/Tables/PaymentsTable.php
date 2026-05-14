<?php

namespace App\Filament\Admin\Resources\Payments\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('booking.booking_code')
                    ->label('Booking')
                    ->searchable(),

                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->badge(),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'unpaid' => 'warning',
                        'waiting_verification' => 'info',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        'waiting_driver_collection' => 'warning',
                        'cash_received' => 'info',
                        'settled' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime(),

                TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime(),
            ])

            ->recordActions([

                ActionGroup::make([
                    Action::make('verify')
                        ->label('verifikasi')
                        ->color('success')
                        ->visible(fn ($record) =>
                            $record->status === 'waiting_verification'
                        )
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'verified',
                                'verified_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Payment verified')
                                ->success()
                                ->send();
                        }),

                    Action::make('reject')
                        ->label('ditolak')
                        ->color('danger')
                        ->visible(fn ($record) =>
                            $record->status === 'waiting_verification'
                        )
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'rejected'
                            ]);

                            Notification::make()
                                ->title('Payment rejected')
                                ->danger()
                                ->send();
                        }),

                    // 💵 DRIVER CONFIRM CASH
                    Action::make('cash_received')
                        ->label('cash diterima')
                        ->color('warning')
                        ->visible(fn ($record) =>
                            $record->status === 'waiting_driver_collection'
                        )
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'cash_received',
                                'driver_received_cash' => true,
                                'driver_received_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Cash received by driver')
                                ->success()
                                ->send();
                        }),

                    // 🏁 SETTLE TO ADMIN
                    Action::make('settle')
                        ->label('settle ke admin')
                        ->color('success')
                        ->visible(fn ($record) =>
                            $record->status === 'cash_received'
                        )
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'settled',
                                'settled_to_admin_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Payment settled')
                                ->label('Pembayaran telah disettle ke admin')
                                ->success()
                                ->send();
                        }),

                ])
            ]);
    }
}