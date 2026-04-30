<?php

namespace App\Filament\Admin\Resources\Bookings\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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

                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->badge(),

                TextColumn::make('pickup_location')
                    ->label('Rute')
                    ->formatStateUsing(fn($record) =>
                        $record->pickup_location . ' → ' . $record->destination
                    ),

                TextColumn::make('total_passengers')
                    ->label('Pax')
                    ->badge(),

                TextColumn::make('price')
                    ->money('IDR'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'cancel_request' => 'Menunggu Persetujuan',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancel_request' => 'info',
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

                    Action::make('request_cancel')
                        ->label('Ajukan Cancel')
                        ->color('warning')
                        ->visible(fn($record) =>
                            auth()->check()
                            && auth()->id() == $record->user_id
                            && in_array($record->status, ['pending', 'confirmed'])
                        )
                        ->requiresConfirmation()
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'cancel_request'
                            ]);

                            $adminEmail = env('MAIL_FROM_ADDRESS', 'nylaadjah@gmail.com');

                            Mail::raw(
                                "Customer {$record->user?->name} mengajukan cancel booking {$record->booking_code}",
                                function ($message) use ($adminEmail) {
                                    $message->to($adminEmail)
                                        ->subject('Cancel Request Booking');
                                }
                            );

                            Notification::make()
                                ->title('Cancel diajukan & email terkirim')
                                ->success()
                                ->send();
                        }),

                    // =========================
                    // ADMIN APPROVE CANCEL
                    // =========================
                    Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->visible(fn($record) =>
                            auth()->check()
                            && auth()->user()->hasRole('admin')
                            && $record->status === 'cancel_request'
                        )
                        ->requiresConfirmation()
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'cancelled'
                            ]);

                            if ($record->user?->email) {
                                Mail::raw(
                                    "Booking {$record->booking_code} berhasil dibatalkan.",
                                    function ($message) use ($record) {
                                        $message->to($record->user->email)
                                            ->subject('Cancel Disetujui');
                                    }
                                );
                            }

                            Notification::make()
                                ->title('Cancel disetujui')
                                ->success()
                                ->send();
                        }),

                    Action::make('reject')
                        ->label('Reject')
                        ->color('danger')
                        ->visible(fn($record) =>
                            auth()->check()
                            && auth()->user()->hasRole('admin')
                            && $record->status === 'cancel_request'
                        )
                        ->requiresConfirmation()
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'confirmed'
                            ]);

                            if ($record->user?->email) {
                                Mail::raw(
                                    "Cancel booking {$record->booking_code} ditolak.",
                                    function ($message) use ($record) {
                                        $message->to($record->user->email)
                                            ->subject('Cancel Ditolak');
                                    }
                                );
                            }

                            Notification::make()
                                ->title('Cancel ditolak')
                                ->danger()
                                ->send();
                        }),

                ])

            ])

            ->striped()
            ->paginated([10, 25, 50]);
    }
}