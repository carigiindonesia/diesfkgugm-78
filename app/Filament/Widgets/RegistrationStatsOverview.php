<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegistrationStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $paidOrders = Order::where('status', 'paid');
        $totalRevenue = (clone $paidOrders)->sum('total_amount');
        $pendingCount = Order::where('status', 'pending')->count();
        $checkedInCount = Ticket::where('is_checked_in', true)->count();

        return [
            Stat::make('Pesanan Lunas', $paidOrders->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->icon('heroicon-o-banknotes')
                ->color('warning'),
            Stat::make('Pesanan Pending', $pendingCount)
                ->icon('heroicon-o-clock')
                ->color('info'),
            Stat::make('Sudah Check-in', $checkedInCount)
                ->icon('heroicon-o-user-group')
                ->color('primary'),
        ];
    }
}
