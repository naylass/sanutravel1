<?php

namespace App\Filament\Admin\Resources\Incomes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class IncomesTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('payment.booking.booking_code')
                    ->label('Booking')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->payment?->booking?->booking_code ?? '-'
                    )
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('gray')
                    ->copyable()
                    ->copyMessage('Kode berhasil disalin'),

                TextColumn::make('payment.booking.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->icon('heroicon-o-user')
                    ->description(
                        fn($record) =>
                        $record->payment?->booking?->destination ?? ''
                    ),

                TextColumn::make('payment.payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'qris'     => 'QRIS',
                        'cash'     => 'Cash',
                        'transfer' => 'Transfer',
                        default    => '-',
                    })
                    ->color(fn($state) => match ($state) {
                        'qris'     => 'success',
                        'cash'     => 'warning',
                        'transfer' => 'info',
                        default    => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
                        'qris'     => 'heroicon-o-qr-code',
                        'cash'     => 'heroicon-o-banknotes',
                        'transfer' => 'heroicon-o-building-library',
                        default    => 'heroicon-o-credit-card',
                    }),

                TextColumn::make('payment.bank_name')
                    ->label('Bank')
                    ->placeholder('-')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('amount')
                    ->label('Income')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold')
                    ->summarize([
                        Sum::make()
                            ->label('Total Income')
                            ->money('IDR'),
                        Count::make()
                            ->label('Jumlah Transaksi'),
                    ]),

                TextColumn::make('income_type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'booking' => 'Booking',
                        // 'manual'  => 'Manual',
                        default   => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'booking' => 'success',
                        // 'manual'  => 'warning',
                        default   => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
                        'booking' => 'heroicon-o-banknotes',
                        // 'manual'  => 'heroicon-o-pencil',
                        default   => null,
                    }),

                TextColumn::make('payment.status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'verified'      => 'Verified',
                        'settled'       => 'Settled',
                        'cash_received' => 'Cash Diterima',
                        default         => $state ? ucfirst($state) : '-',
                    })
                    ->color(fn($state) => match ($state) {
                        'verified'      => 'success',
                        'settled'       => 'primary',
                        'cash_received' => 'warning',
                        default         => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
                        'verified'      => 'heroicon-o-check-circle',
                        'settled'       => 'heroicon-o-check-badge',
                        'cash_received' => 'heroicon-o-banknotes',
                        default         => null,
                    }),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->limit(50)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('income_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-calendar'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                Filter::make('income_date')
                    ->label('Rentang Tanggal')
                    ->form([
                        DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->placeholder('dd/mm/yyyy')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->maxDate(now()),
                        DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->placeholder('dd/mm/yyyy')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->maxDate(now()),
                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                !empty($data['from']),
                                fn($q) => $q->whereDate('income_date', '>=', $data['from'])
                            )
                            ->when(
                                !empty($data['until']),
                                fn($q) => $q->whereDate('income_date', '<=', $data['until'])
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if (!empty($data['from'])) {
                            $indicators[] = 'Dari: ' . Carbon::parse($data['from'])->translatedFormat('d M Y');
                        }
                        if (!empty($data['until'])) {
                            $indicators[] = 'Sampai: ' . Carbon::parse($data['until'])->translatedFormat('d M Y');
                        }
                        return $indicators;
                    }),

                Filter::make('this_month')
                    ->label('Bulan Ini')
                    ->query(
                        fn(Builder $query) =>
                        $query->whereMonth('income_date', now()->month)
                            ->whereYear('income_date', now()->year)
                    )
                    ->toggle(),

                Filter::make('last_month')
                    ->label('Bulan Lalu')
                    ->query(
                        fn(Builder $query) =>
                        $query->whereMonth('income_date', now()->subMonth()->month)
                            ->whereYear('income_date', now()->subMonth()->year)
                    )
                    ->toggle(),
                SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'qris'     => 'QRIS',
                        'cash'     => 'Cash',
                        'transfer' => 'Transfer',
                    ])
                    ->native(false)
                    ->placeholder('Semua Metode')
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) return $query;
                        return $query->whereHas(
                            'payment',
                            fn($q) =>
                            $q->where('payment_method', $data['value'])
                        );
                    }),

                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'verified'      => 'Verified',
                        'settled'       => 'Settled',
                        'cash_received' => 'Cash Diterima',
                    ])
                    ->native(false)
                    ->placeholder('Semua Status')
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) return $query;
                        return $query->whereHas(
                            'payment',
                            fn($q) =>
                            $q->where('status', $data['value'])
                        );
                    }),

            ], layout: FiltersLayout::AboveContentCollapsible)

            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    // EditAction::make()
                    //     ->visible(fn($record) => $record->income_type === 'manual'),
                    // DeleteAction::make()
                    //     ->visible(fn($record) => $record->income_type === 'manual'),
                ])
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->striped()
            ->defaultSort('income_date', 'desc')
            ->paginated([10, 25, 50])
            ->persistFiltersInSession()
            ->filtersFormColumns(3)
            ->emptyStateHeading('Belum ada data income')
            ->emptyStateDescription('Income akan muncul otomatis setelah pembayaran diverifikasi atau di-settle.')
            ->emptyStateIcon('heroicon-o-banknotes');
    }
}
