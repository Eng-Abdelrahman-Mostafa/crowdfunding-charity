<?php

namespace App\Filament\Pages;

use App\Services\DashboardService;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\MonthlyDonationsChart;
use App\Filament\Widgets\CampaignsStatusChart;
use App\Filament\Widgets\TopCampaignsWidget;
use App\Filament\Widgets\RecentDonationsWidget;
use App\Filament\Widgets\RecentWithdrawalsWidget;
use App\Filament\Widgets\DonationsByCategoryChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    // Define widget widths
    protected string $statsWidgetColumnSpan = 'full';
    protected int $chartWidgetColumnSpan = 6;
    protected int $tableWidgetColumnSpan = 6;

    public function getWidgets(): array
    {
        // Check if user is admin or association manager
        $isAdmin = auth()->user()->type === 'admin';

        $widgets = [];

        if ($isAdmin) {
            // Admin widgets
            $widgets = [
                StatsOverview::class,
                MonthlyDonationsChart::class,
                CampaignsStatusChart::class,
                DonationsByCategoryChart::class,
                TopCampaignsWidget::class,
                RecentDonationsWidget::class,
                RecentWithdrawalsWidget::class,
            ];
        } else {
            // Association manager widgets
            $widgets = [
                \App\Filament\Widgets\AssociationManagerStatsOverview::class,
                \App\Filament\Widgets\AssociationManagerMonthlyDonationsChart::class,
                \App\Filament\Widgets\AssociationManagerCampaignsStatusChart::class,
                \App\Filament\Widgets\AssociationManagerDonationsByCategoryChart::class,
                \App\Filament\Widgets\AssociationManagerTopCampaignsWidget::class,
                \App\Filament\Widgets\AssociationManagerRecentDonationsWidget::class,
                \App\Filament\Widgets\AssociationManagerRecentWithdrawalsWidget::class,
            ];
        }

        return $widgets;
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
