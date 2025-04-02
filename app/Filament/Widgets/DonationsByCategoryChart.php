<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Widgets\ChartWidget;

class DonationsByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Donations by Category';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 4;
    protected static ?int $chartHeight = 300;
    public static function canView(): bool
    {
        return auth()->user()->type === 'admin';
    }
    public function getHeading(): string
    {
        return __('dashboard.Donations by Category');
    }

    protected function getData(): array
    {
        $dashboardService = new DashboardService();
        $donationsByCategory = $dashboardService->getDonationsByCategory();

        // Generate some random colors for the chart
        $colors = [];
        for ($i = 0; $i < count($donationsByCategory['labels']); $i++) {
            $colors[] = $this->getRandomColor();
        }

        return [
            'datasets' => [
                [
                    'label' => __('Donation Amount'),
                    'data' => $donationsByCategory['data'],
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $donationsByCategory['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
            ],
        ];
    }

    private function getRandomColor(): string
    {
        $colors = [
            '#4CAF50', '#2196F3', '#9C27B0', '#F44336', '#FF9800',
            '#795548', '#607D8B', '#3F51B5', '#009688', '#FFC107',
            '#673AB7', '#E91E63', '#CDDC39', '#9E9E9E', '#00BCD4'
        ];

        return $colors[array_rand($colors)];
    }
}
