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
        // TOTAL BOOKING AKTIF
        $totalBooking = Booking::whereNotIn('status', [
            'cancelled',
            'rejected',
        ])->count();

        // BOOKING HARI INI
        $todayBooking = Booking::whereDate(
            'created_at',
            today()
        )->count();

        // PAYMENT PENDING
        $pendingPayment = Payment::whereIn('status', [
            'waiting_verification',
            'waiting_driver_collection',
        ])->count();

        // PAYMENT SUCCESS
        $verifiedPayment = Payment::whereIn('status', [
            'verified',
            'settled',
        ])->count();

        // SCHEDULE AKTIF
        $activeSchedule = Schedule::whereDate(
            'departure_date',
            '>=',
            today()
        )->count();

        // TOTAL INCOME
        $todayIncome = Payment::whereIn('status', [
            'verified',
            'settled',
        ])->sum('amount');

        return [

            // BOOKING
            Stat::make(
                'Total Booking',
                (string) $totalBooking
            )
                ->description($todayBooking . ' booking hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-ticket')
                ->chart([12, 15, 10, 18, 25, 20, 28])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            // PENDING PAYMENT
            Stat::make(
                'Pending Payment',
                (string) $pendingPayment
            )
                ->description('Menunggu verifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-credit-card')
                ->chart([8, 12, 10, 14, 9, 11, 13])
                ->color('warning')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            // SUCCESS PAYMENT
            Stat::make(
                'Pembayaran Berhasil',
                (string) $verifiedPayment
            )
                ->description('Payment sukses')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-check-badge')
                ->chart([4, 8, 12, 10, 18, 20, 24])
                ->color('success')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            // ACTIVE SCHEDULE
            Stat::make(
                'Schedule Aktif',
                (string) $activeSchedule
            )
                ->description('Jadwal perjalanan aktif')
                ->descriptionIcon('heroicon-m-map')
                ->icon('heroicon-o-calendar-days')
                ->chart([2, 4, 3, 5, 6, 5, 7])
                ->color('info')
                ->extraAttributes([
                    'class' => 'rounded-2xl shadow-sm',
                ]),

            // INCOME
            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format($todayIncome, 0, ',', '.')
            )
                ->description('Verified & settled')
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