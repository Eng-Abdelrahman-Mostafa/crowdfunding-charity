<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssociationManagerStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 12;

    // Add this to ensure the widget is only visible to association managers
    public static function canView(): bool
    {
        return auth()->user()->type === 'association_manager';
    }
    public function getStats(): array
    {
        $dashboardService = new DashboardService();
        $stats = $dashboardService->getAssociationManagerStats(auth()->id());

        return [
            Stat::make(__('dashboard.Your Associations'), $stats['total_associations'])
                ->description(__('dashboard.Associations you manage'))
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make(__('dashboard.Your Campaigns'), $stats['total_campaigns'])
                ->description(__('dashboard.Campaigns you manage'))
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),

            Stat::make(__('dashboard.Total Donations'), number_format($stats['total_donation_amount'], 2) . ' ' . config('app.currency', 'EGP'))
                ->description(__('dashboard.:count donations received', ['count' => $stats['total_donations']]))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            // Removing Goal Amount since it may duplicate with Total Donations in meaning for assoc managers

            Stat::make(__('dashboard.Expenditures'), number_format($stats['expenditures_amount'], 2) . ' ' . config('app.currency', 'EGP'))
                ->description(__('dashboard.Total spent from campaigns'))
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger'),

            Stat::make(__('dashboard.Withdrawals'), number_format($stats['total_withdrawals'], 2) . ' ' . config('app.currency', 'EGP'))
                ->description(__('dashboard.:count pending withdrawals', ['count' => $stats['pending_withdrawals']]))
                ->descriptionIcon('heroicon-m-arrow-uturn-down')
                ->color('info'),
        ];
    }
}
