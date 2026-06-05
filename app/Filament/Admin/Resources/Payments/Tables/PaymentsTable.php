<?php

namespace App\Filament\Admin\Resources\Payments\Tables;

use App\Services\PaymentService;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('booking.booking_code')
                    ->label('Booking')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->weight('bold'),

                TextColumn::make('booking.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->weight('medium'),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'qris'     => 'QRIS',
                        'cash'     => 'Cash',
                        'transfer' => 'Transfer Bank',
                        default    => '-',
                    })
                    ->color(fn($state) => match ($state) {
                        'qris'     => 'info',
                        'cash'     => 'warning',
                        'transfer' => 'success',
                        default    => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
                        'qris'     => 'heroicon-o-qr-code',
                        'cash'     => 'heroicon-o-banknotes',
                        'transfer' => 'heroicon-o-building-library',
                        default    => 'heroicon-o-credit-card',
                    }),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success'),

                ImageColumn::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->getStateUsing(fn($record) => $record->payment_proof
                        ? url('storage/' . $record->payment_proof)
                        : null
                    )
                    ->height(80),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'unpaid'                    => 'Belum Bayar',
                        'waiting_verification'      => 'Menunggu Verifikasi',
                        'verified'                  => 'Verified',
                        'rejected'                  => 'Ditolak',
                        'waiting_driver_collection' => 'Menunggu Driver',
                        'cash_received'             => 'Cash Diterima',
                        'settled'                   => 'Settled',
                        default                     => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'unpaid'                    => 'gray',
                        'waiting_verification'      => 'warning',
                        'verified'                  => 'success',
                        'rejected'                  => 'danger',
                        'waiting_driver_collection' => 'info',
                        'cash_received'             => 'primary',
                        'settled'                   => 'success',
                        default                     => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->icon('heroicon-o-check-circle'),

                TextColumn::make('verified_at')
                    ->label('Verified')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->icon('heroicon-o-check-circle'),
            ])

            ->recordActions([
                ActionGroup::make([

                    // ============================================
                    // VERIFIKASI — QRIS & Transfer
                    // ============================================
                    Action::make('verify')
                        ->label('Verifikasi')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Verifikasi Pembayaran')
                        ->modalDescription('Email + WA notifikasi akan dikirim ke customer.')
                        ->visible(fn($record) =>
                            $record->status === 'waiting_verification'
                        )
                        ->action(function ($record) {
                            $record->load('booking');
                            PaymentService::verify($record);

                            Notification::make()
                                ->title('Pembayaran diverifikasi, notifikasi terkirim')
                                ->success()
                                ->send();
                        }),

                    // ============================================
                    // TOLAK — QRIS & Transfer
                    // ============================================
                    Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Pembayaran')
                        ->modalDescription('Email + WA penolakan akan dikirim ke customer.')
                        ->visible(fn($record) =>
                            $record->status === 'waiting_verification'
                        )
                        ->action(function ($record) {
                            $record->load('booking');
                            PaymentService::reject($record);

                            Notification::make()
                                ->title('Pembayaran ditolak, notifikasi terkirim')
                                ->danger()
                                ->send();
                        }),

                    // ============================================
                    // CASH DITERIMA — Cash (driver sudah serahkan)
                    // ============================================
                    Action::make('cash_received')
                        ->label('Cash Diterima')
                        ->icon('heroicon-o-banknotes')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn($record) =>
                            $record->status === 'waiting_driver_collection'
                        )
                        ->action(function ($record) {
                            $now = now('Asia/Jakarta');

                            $record->update([
                                'status'               => 'cash_received',
                                'driver_received_cash' => true,
                                'driver_received_at'   => $now,
                                'paid_at'              => $now,
                                'verified_at'          => $now,
                            ]);

                            if ($record->booking) {
                                $record->booking->update(['status' => 'confirmed']);
                            }

                            Notification::make()
                                ->title('Cash berhasil diterima')
                                ->success()
                                ->send();
                        }),

                    // ============================================
                    // SETTLE — Cash (kirim notif + PDF ke customer)
                    // ============================================
                    Action::make('settle')
                        ->label('Settle')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Settle Pembayaran Cash')
                        ->modalDescription('Email + WA receipt akan dikirim ke customer.')
                        ->visible(fn($record) =>
                            $record->status === 'cash_received'
                        )
                        ->action(function ($record) {
                            $record->load('booking');
                            PaymentService::settle($record);

                            Notification::make()
                                ->title('Pembayaran settled, notifikasi terkirim')
                                ->success()
                                ->send();
                        }),
                ])
            ])

            ->striped()
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}