<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Schedule;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalBooking = Booking::count();

        $pendingPayment = Payment::whereIn('status', [
            'waiting_verification',
            'waiting_driver_collection',
        ])->count();

        $activeSchedule = Schedule::count();

        $verifiedPayment = Payment::where('status', 'verified')->count();

        $todayBooking = Booking::whereDate('created_at', today())->count();

        $todayIncome = Payment::whereIn('status', [
            'verified',
            'settled',
        ])->sum('amount');

        return [

            Stat::make('Total Booking', number_format($totalBooking))
                ->description($todayBooking . ' booking hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-ticket')
                ->chart([12, 15, 10, 18, 25, 20, 28])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            Stat::make('Pending Payment', number_format($pendingPayment))
                ->description('Menunggu verifikasi/admin')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-credit-card')
                ->chart([8, 12, 10, 14, 9, 11, 13])
                ->color('warning')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            Stat::make('Pembayaran Berhasil', number_format($verifiedPayment))
                ->description('Pembayaran sukses')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-check-badge')
                ->chart([4, 8, 12, 10, 18, 20, 24])
                ->color('success')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            Stat::make('Schedule Aktif', number_format($activeSchedule))
                ->description('Jadwal perjalanan')
                ->descriptionIcon('heroicon-m-map')
                ->icon('heroicon-o-calendar-days')
                ->chart([2, 4, 3, 5, 6, 5, 7])
                ->color('info')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format($todayIncome, 0, ',', '.')
            )
                ->description('Pembayaran verified + settled')
                ->descriptionIcon('heroicon-m-banknotes')
                ->icon('heroicon-o-banknotes')
                ->chart([10, 18, 15, 25, 20, 30, 35])
                ->color('success')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),
        ];
    }
}