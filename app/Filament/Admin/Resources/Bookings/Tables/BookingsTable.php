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
use App\Mail\CancelApprovedMail;
use App\Mail\CancelRejectedMail;
use App\Services\WhatsappService;

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
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-m-ticket')
                    ->sortable(),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn($record) => $record->email)
                    ->icon('heroicon-m-user-circle')
                    ->weight('semiBold'),

                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'Reguler' => 'info',
                        'Eksklusif' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
                        'Reguler' => 'heroicon-m-user-group',
                        'Eksklusif' => 'heroicon-m-star',
                        default => 'heroicon-m-ticket',
                    }),

                TextColumn::make('area')
                    ->label('Area')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-map-pin'),

                TextColumn::make('pickup_location')
                    ->label('Penjemputan')
                    ->limit(35)
                    ->tooltip(fn($record) => $record->pickup_location)
                    ->icon('heroicon-m-truck'),

                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->destination)
                    ->icon('heroicon-m-flag'),

                TextColumn::make('pickup_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-calendar-days'),

                TextColumn::make('pickup_time')
                    ->label('Jam')
                    ->icon('heroicon-m-clock')
                    ->badge()
                    ->color('info'),

                TextColumn::make('total_passengers')
                    ->label('Pax')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-m-users'),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->sortable()
                    ->icon('heroicon-m-banknotes'),

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
                    })

                    ->icon(fn($state) => match ($state) {

                        'pending' => 'heroicon-m-clock',
                        'confirmed' => 'heroicon-m-check-circle',
                        'scheduled' => 'heroicon-m-calendar',
                        'on_progress' => 'heroicon-m-truck',
                        'completed' => 'heroicon-m-check-badge',
                        'cancel_request' => 'heroicon-m-exclamation-triangle',
                        'cancelled' => 'heroicon-m-x-circle',

                        default => 'heroicon-m-information-circle',
                    }),
            ])

            ->recordActions([

                ActionGroup::make([
                    ViewAction::make()
                        ->color('gray'),
                    EditAction::make()
                        ->color('primary'),
                    DeleteAction::make()
                        ->visible(fn() => auth()->user()?->hasRole('admin'))
                        ->color('danger'),

                    Action::make('approve_cancel')
                        ->label('Approve Cancel')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->visible(fn($record) => $record->status === 'cancel_request')
                        ->requiresConfirmation()
                        ->modalHeading('Batalkan Booking?')
                        ->modalDescription('Booking akan dibatalkan dan notifikasi dikirim ke customer.')
                        ->action(function ($record) {

                            $record->update(['status' => 'cancelled']);

                            try {
                                if (!empty($record->email)) {
                                    Mail::to($record->email)
                                        ->send(new CancelApprovedMail($record));
                                }
                            } catch (\Exception $e) {
                                logger('EMAIL CANCEL APPROVED ERROR: ' . $e->getMessage());
                            }

                            try {
                                WhatsappService::send(
                                    $record->phone_number,
                                    "❌ BOOKING DIBATALKAN\n\n" .
                                        "Halo {$record->customer_name},\n\n" .
                                        "Booking Anda telah DIBATALKAN oleh admin.\n\n" .
                                        "📌 Kode Booking: {$record->booking_code}\n" .
                                        "🏁 Tujuan: {$record->destination}\n\n" .
                                        "Terima kasih, Sanu Travel 🚐"
                                );
                            } catch (\Exception $e) {
                                logger('WA CANCEL APPROVED ERROR: ' . $e->getMessage());
                            }

                            try {
                                WhatsappService::send(
                                    '6287764868369',
                                    "✅ CANCEL DISETUJUI\n\n" .
                                        "Kode: {$record->booking_code}\n" .
                                        "Customer: {$record->customer_name}\n" .
                                        "Tujuan: {$record->destination}\n" .
                                        "Status: CANCELLED"
                                );
                            } catch (\Exception $e) {
                                logger('WA ADMIN APPROVE CANCEL ERROR: ' . $e->getMessage());
                            }

                            Notification::make()
                                ->title('Booking dibatalkan, notifikasi terkirim')
                                ->success()
                                ->send();
                        }),

                    Action::make('reject_cancel')
                        ->label('Reject Cancel')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->visible(fn($record) => $record->status === 'cancel_request')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Request Cancel?')
                        ->modalDescription('Booking kembali aktif dan notifikasi dikirim ke customer.')
                        ->action(function ($record) {

                            $record->update(['status' => 'confirmed']);

                            try {
                                if (!empty($record->email)) {
                                    Mail::to($record->email)
                                        ->send(new CancelRejectedMail($record));
                                }
                            } catch (\Exception $e) {
                                logger('EMAIL CANCEL REJECT ERROR: ' . $e->getMessage());
                            }

                            try {
                                WhatsappService::send(
                                    $record->phone_number,
                                    "🚐 PERMINTAAN CANCEL DITOLAK\n\n" .
                                        "Halo {$record->customer_name},\n\n" .
                                        "Permintaan cancel Anda DITOLAK oleh admin.\n" .
                                        "Booking Anda tetap aktif.\n\n" .
                                        "📌 Kode Booking: {$record->booking_code}\n" .
                                        "🏁 Tujuan: {$record->destination}\n\n" .
                                        "Terima kasih, Sanu Travel 🚐"
                                );
                            } catch (\Exception $e) {
                                logger('WA CANCEL REJECT ERROR: ' . $e->getMessage());
                            }

                            // WA ADMIN
                            try {
                                WhatsappService::send(
                                    '6287764868369',
                                    "🚫 CANCEL DITOLAK\n\n" .
                                        "Kode: {$record->booking_code}\n" .
                                        "Customer: {$record->customer_name}\n" .
                                        "Tujuan: {$record->destination}\n" .
                                        "Status: CONFIRMED (kembali aktif)"
                                );
                            } catch (\Exception $e) {
                                logger('WA ADMIN REJECT CANCEL ERROR: ' . $e->getMessage());
                            }

                            Notification::make()
                                ->title('Request cancel ditolak, notifikasi terkirim')
                                ->warning()
                                ->send();
                        }),
                ])
            ])


            ->striped()

            ->defaultSort('pickup_date', 'desc')

            ->paginated([10, 25, 50])

            ->defaultPaginationPageOption(10)

            ->emptyStateHeading('Belum ada booking')

            ->emptyStateDescription('Booking customer akan muncul di sini.')

            ->emptyStateIcon('heroicon-o-ticket');
    }
}
