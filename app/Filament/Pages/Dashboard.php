<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // We only need to use getHeaderWidgets() OR getWidgets(), not both
    // Using getWidgets() is more consistent with Filament 3
    public function getWidgets(): array
    {
        // Check if user is admin or association manager
        $isAdmin = auth()->user()->type === 'admin';

        if ($isAdmin) {
            // Admin widgets
            return [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\MonthlyDonationsChart::class,
                \App\Filament\Widgets\CampaignsStatusChart::class,
                \App\Filament\Widgets\DonationsByCategoryChart::class,
                \App\Filament\Widgets\TopCampaignsWidget::class,
                \App\Filament\Widgets\RecentDonationsWidget::class,
                \App\Filament\Widgets\RecentWithdrawalsWidget::class,
            ];
        } else {
            // Association manager widgets
            return [
                \App\Filament\Widgets\AssociationManagerStatsOverview::class,
                \App\Filament\Widgets\AssociationManagerMonthlyDonationsChart::class,
                \App\Filament\Widgets\AssociationManagerCampaignsStatusChart::class,
                \App\Filament\Widgets\AssociationManagerDonationsByCategoryChart::class,
                \App\Filament\Widgets\AssociationManagerTopCampaignsWidget::class,
                \App\Filament\Widgets\AssociationManagerRecentDonationsWidget::class,
                \App\Filament\Widgets\AssociationManagerRecentWithdrawalsWidget::class,
            ];
        }
    }

    // Override but return null to prevent unexpected behavior
    protected function getHeaderWidgets(): array
    {
        return [];
    }

    // Override but return null to prevent unexpected behavior
    protected function getFooterWidgets(): array
    {
        return [];
    }

    public function getColumns(): int | array
    {
        return 12;
    }

    public function getTitle(): string
    {
        return auth()->user()->type === 'admin'
            ? __('dashboard.Admin Dashboard')
            : __('dashboard.Association Manager Dashboard');
    }
}
