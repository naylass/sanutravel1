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

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | BOOKING CODE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary')
                    ->icon('heroicon-m-ticket')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER
                |--------------------------------------------------------------------------
                */

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn ($record) => $record->email)
                    ->icon('heroicon-m-user-circle')
                    ->weight('semiBold'),

                /*
                |--------------------------------------------------------------------------
                | SERVICE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Reguler' => 'info',
                        'Eksklusif' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn ($state) => match ($state) {
                        'Reguler' => 'heroicon-m-user-group',
                        'Eksklusif' => 'heroicon-m-star',
                        default => 'heroicon-m-ticket',
                    }),

                /*
                |--------------------------------------------------------------------------
                | AREA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('area')
                    ->label('Area')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-map-pin'),

                /*
                |--------------------------------------------------------------------------
                | PICKUP
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pickup_location')
                    ->label('Penjemputan')
                    ->limit(35)
                    ->tooltip(fn ($record) => $record->pickup_location)
                    ->icon('heroicon-m-truck'),

                /*
                |--------------------------------------------------------------------------
                | DESTINATION
                |--------------------------------------------------------------------------
                */

                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->destination)
                    ->icon('heroicon-m-flag'),

                /*
                |--------------------------------------------------------------------------
                | DATE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pickup_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-calendar-days'),

                /*
                |--------------------------------------------------------------------------
                | TIME
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pickup_time')
                    ->label('Jam')
                    ->icon('heroicon-m-clock')
                    ->badge()
                    ->color('info'),

                /*
                |--------------------------------------------------------------------------
                | PASSENGERS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('total_passengers')
                    ->label('Pax')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-m-users'),

                /*
                |--------------------------------------------------------------------------
                | TOTAL PRICE
                |--------------------------------------------------------------------------
                */

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->sortable()
                    ->icon('heroicon-m-banknotes'),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {

                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'scheduled' => 'Terjadwal',
                        'on_progress' => 'Perjalanan',
                        'completed' => 'Selesai',
                        'cancel_request' => 'Request Cancel',
                        'cancelled' => 'Dibatalkan',

                        default => $state,
                    })

                    ->color(fn ($state) => match ($state) {

                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'scheduled' => 'info',
                        'on_progress' => 'primary',
                        'completed' => 'success',
                        'cancel_request' => 'warning',
                        'cancelled' => 'danger',

                        default => 'gray',
                    })

                    ->icon(fn ($state) => match ($state) {

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

            /*
            |--------------------------------------------------------------------------
            | ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                ActionGroup::make([

                    ViewAction::make()
                        ->color('gray'),

                    EditAction::make()
                        ->color('primary'),

                    DeleteAction::make()
                        ->visible(fn () => auth()->user()?->hasRole('admin'))
                        ->color('danger'),

                    /*
                    |--------------------------------------------------------------------------
                    | APPROVE CANCEL
                    |--------------------------------------------------------------------------
                    */

                    Action::make('approve_cancel')

                        ->label('Approve Cancel')

                        ->icon('heroicon-m-check-circle')

                        ->color('success')

                        ->visible(
                            fn ($record) =>
                            $record->status === 'cancel_request'
                        )

                        ->requiresConfirmation()

                        ->modalHeading('Batalkan Booking?')

                        ->modalDescription('Booking akan dibatalkan permanen.')

                        ->action(function ($record) {

                            $record->update([
                                'status' => 'cancelled'
                            ]);

                            Notification::make()
                                ->title('Booking berhasil dibatalkan')
                                ->success()
                                ->send();
                        }),

                    /*
                    |--------------------------------------------------------------------------
                    | REJECT CANCEL
                    |--------------------------------------------------------------------------
                    */

                    Action::make('reject_cancel')

                        ->label('Reject Cancel')

                        ->icon('heroicon-m-x-circle')

                        ->color('danger')

                        ->visible(
                            fn ($record) =>
                            $record->status === 'cancel_request'
                        )

                        ->requiresConfirmation()

                        ->modalHeading('Tolak Request Cancel?')

                        ->action(function ($record) {

                            $record->update([
                                'status' => 'confirmed'
                            ]);

                            Notification::make()
                                ->title('Request cancel ditolak')
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