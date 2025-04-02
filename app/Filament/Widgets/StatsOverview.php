<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 12;
    public function getStats(): array
    {
        $dashboardService = new DashboardService();
        $stats = $dashboardService->getAdminStats();

        return [
            Stat::make(__('dashboard.Total Users'), $stats['total_users'])
                ->description(__('dashboard.Including admins, managers, and donors'))
                ->descriptionIcon('heroicon-m-user')
                ->color('primary'),

            Stat::make(__('dashboard.Total Associations'), $stats['total_associations'])
                ->description(__('dashboard.Registered associations'))
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),

            Stat::make(__('dashboard.Total Campaigns'), $stats['total_campaigns'])
                ->description(__('dashboard.Active and inactive campaigns'))
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),

            Stat::make(__('dashboard.Total Donations'), number_format($stats['total_donation_amount'], 2) . ' ' . config('app.currency', 'EGP'))
                ->description(__('dashboard.:count successful donations', ['count' => $stats['total_donations']]))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make(__('dashboard.Goal Amount'), number_format($stats['goal_amount'], 2) . ' ' . config('app.currency', 'EGP'))
                ->description(__('dashboard.Total fundraising goal'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),

            Stat::make(__('dashboard.Pending Withdrawals'), $stats['pending_withdrawals'])
                ->description(__('dashboard.Waiting for approval'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
    public static function canView(): bool
    {
        return auth()->user()->type === 'admin';
    }
}
