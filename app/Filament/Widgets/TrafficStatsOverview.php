<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrafficStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $today = SiteVisit::today();
        $totalToday = (clone $today)->count();
        $uniqueIpsToday = (clone $today)->distinct('ip_address')->count('ip_address');
        $registrationsToday = (clone $today)->where('page_type', 'registration_submit')->count();
        $paymentsToday = (clone $today)->where('page_type', 'payment')->where('order_status', 'paid')->count();
        $totalAll = SiteVisit::count();
        $uniqueIpsAll = SiteVisit::distinct('ip_address')->count('ip_address');

        return [
            Stat::make('Kunjungan Hari Ini', $totalToday)
                ->icon('heroicon-o-eye')
                ->description('Total hit hari ini')
                ->color('info'),
            Stat::make('IP Unik Hari Ini', $uniqueIpsToday)
                ->icon('heroicon-o-globe-alt')
                ->description('Pengunjung unik hari ini')
                ->color('primary'),
            Stat::make('Registrasi Hari Ini', $registrationsToday)
                ->icon('heroicon-o-document-text')
                ->description('Form submit hari ini')
                ->color('warning'),
            Stat::make('Pembayaran Hari Ini', $paymentsToday)
                ->icon('heroicon-o-banknotes')
                ->description('Pembayaran berhasil hari ini')
                ->color('success'),
            Stat::make('Total Kunjungan', $totalAll)
                ->icon('heroicon-o-chart-bar')
                ->description('Sejak awal')
                ->color('gray'),
            Stat::make('Total IP Unik', $uniqueIpsAll)
                ->icon('heroicon-o-users')
                ->description('Sejak awal')
                ->color('gray'),
        ];
    }
}
