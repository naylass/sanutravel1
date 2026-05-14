<?php

namespace App\Filament\Admin\Widgets;

use App\Models\DeliveryOrder;
use App\Models\Driver;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DriverPerformance extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalTrip = DeliveryOrder::count();

        $completedTrip = DeliveryOrder::where(
            'status',
            'completed'
        )->count();

        $ongoingTrip = DeliveryOrder::where(
            'status',
            'ongoing'
        )->count();

        $cancelTrip = DeliveryOrder::where(
            'status',
            'cancelled'
        )->count();

        $successRate = $totalTrip > 0
            ? round(($completedTrip / $totalTrip) * 100)
            : 0;

        return [

            Stat::make(
                'Trip Selesai',
                $completedTrip
            )
                ->description($successRate . '% success rate')
                ->color('success')
                ->chart([10, 20, 18, 25, 30, 40]),

            Stat::make(
                'Sedang Berjalan',
                $ongoingTrip
            )
                ->description('Trip aktif')
                ->color('warning'),

            Stat::make(
                'Trip Cancel',
                $cancelTrip
            )
                ->description('Perjalanan dibatalkan')
                ->color('danger'),
        ];
    }
}