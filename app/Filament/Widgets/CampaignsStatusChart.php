<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Widgets\ChartWidget;

class CampaignsStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Campaigns by Status';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 4;

    protected function getData(): array
    {
        $dashboardService = new DashboardService();
        $campaignsByStatus = $dashboardService->getCampaignsByStatus();

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
