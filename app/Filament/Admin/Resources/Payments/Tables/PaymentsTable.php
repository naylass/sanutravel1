<?php

namespace App\Filament\Admin\Resources\Payments\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentVerifiedMail;
use App\Mail\PaymentRejectedMail;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('booking')
                    ->label('Kode Booking')
                    ->formatStateUsing(fn ($record) =>
                        ($record->booking?->booking_code ?? '-') .
                        ' - ' . ($record->booking?->user?->name ?? '-')
                    )
                    ->searchable(),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge(),

                TextColumn::make('payment_date')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i'),

                TextColumn::make('amount')
                    ->label('Total')
                    ->money('IDR'),

                ImageColumn::make('proof_image')
                    ->label('Bukti'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'waiting' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

            ])

            ->recordActions([

                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),

                    // ✅ VERIFIED BUTTON
                    Action::make('verify')
                        ->label('Verified')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'waiting')
                        ->requiresConfirmation()
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'verified'
                            ]);

                            $record->load('booking.user');

                            if ($record->booking?->user?->email) {
                                Mail::to($record->booking->user->email)
                                    ->send(new PaymentVerifiedMail($record));
                            }
                        }),

                    // ❌ REJECT BUTTON
                    Action::make('reject')
                        ->label('Reject')
                        ->color('danger')
                        ->visible(fn ($record) => $record->status === 'waiting')
                        ->requiresConfirmation()
                        ->action(function ($record) {

                            $record->update([
                                'status' => 'rejected'
                            ]);

                            $record->load('booking.user');

                            if ($record->booking?->user?->email) {
                                Mail::to($record->booking->user->email)
                                    ->send(new PaymentRejectedMail($record));
                            }
                        }),
                ]),

            ]);
    }
}