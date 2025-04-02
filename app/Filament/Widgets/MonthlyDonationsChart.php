<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Widgets\ChartWidget;

class MonthlyDonationsChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Donations';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = 8;
    protected static ?int $chartHeight = 300; // Set a fixed height

    public function getHeading(): string
    {
        return __('dashboard.Monthly Donations');
    }
    public static function canView(): bool
    {
        return auth()->user()->type === 'admin';
    }

    protected function getData(): array
    {
        $dashboardService = new DashboardService();
        $chartData = $dashboardService->getMonthlyDonationsData();

        return [
            'datasets' => [
                [
                    'label' => __('dashboard.Donation Amount'),
                    'data' => $chartData['amounts'],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#2196F3',
                ],
                [
                    'label' => __('dashboard.Number of Donations'),
                    'data' => $chartData['counts'],
                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FF5722',
                    'type' => 'line',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $chartData['months'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'title' => [
                        'display' => true,
                        'text' => __('Amount'),
                    ],
                    'beginAtZero' => true,
                ],
                'y1' => [
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => __('Count'),
                    ],
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => __('Month'),
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
        ];
    }
}
