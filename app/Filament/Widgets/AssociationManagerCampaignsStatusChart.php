<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Widgets\ChartWidget;

class AssociationManagerCampaignsStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Your Campaigns by Status';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 4;
    protected function getData(): array
    {
        $dashboardService = new DashboardService();

        // Get association IDs for current user
        $associationIds = auth()->user()->associations()
            ->select('associations.id') // Specify the table name to avoid ambiguity
            ->pluck('associations.id')
            ->toArray();

        $campaignsByStatus = $dashboardService->getCampaignsByStatus($associationIds);

        return [
            'datasets' => [
                [
                    'data' => array_values($campaignsByStatus),
                    'backgroundColor' => ['#4CAF50', '#F44336'],
                ],
            ],
            'labels' => [__('Active'), __('Inactive')],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
                'tooltip' => [
                    'mode' => 'index',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
