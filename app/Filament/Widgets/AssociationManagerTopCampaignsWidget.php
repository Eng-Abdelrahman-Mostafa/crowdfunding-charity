<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AssociationManagerTopCampaignsWidget extends BaseWidget
{
    protected static ?string $heading = 'Your Top Campaigns by Donations';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 12;

    public ?Collection $records = null;
    public function getHeading(): string
    {
        return __('dashboard.Your Top Campaigns by Donations');
    }
    public function getTableHeading(): string|null
    {
        return __('dashboard.Your Top Campaigns by Donations');
    }
    public static function canView(): bool
    {
        return auth()->user()->type === 'association_manager';
    }

    protected function getTableQuery(): Builder
    {
        return \App\Models\Campaign::query()->limit(0);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('Campaign'))
                ->searchable()
                ->sortable(),

            TextColumn::make('donations_sum_amount')
                ->label(__('Donations'))
                ->money(config('app.currency', 'EGP'))
                ->sortable(),

            TextColumn::make('goal_amount')
                ->label(__('Goal'))
                ->money(config('app.currency', 'EGP'))
                ->sortable(),

            TextColumn::make('progress')
                ->label(__('Progress'))
                ->formatStateUsing(fn ($record): string => number_format(($record->donations_sum_amount / $record->goal_amount) * 100, 1) . '%')
                ->html()
                ->description(function ($record) {
                    $percentage = min(100, ($record->donations_sum_amount / $record->goal_amount) * 100);
                    return '<div class="w-full bg-gray-200 rounded-full h-2.5">
                              <div class="bg-blue-600 h-2.5 rounded-full" style="width: '.$percentage.'%"></div>
                            </div>';
                }),
        ];
    }

    public function getTableRecordsPerPage(): int
    {
        return 5;
    }

    public function getTableContent(): ?\Illuminate\Contracts\View\View
    {
        $dashboardService = new DashboardService();

        // Get association IDs for current user
        $associationIds = auth()->user()->associations()
            ->select('associations.id')
            ->pluck('associations.id')
            ->toArray();

        $topCampaigns = $dashboardService->getTopCampaigns($associationIds);

        // Modify the returned collection to include the progress calculation
        $topCampaigns->each(function ($campaign) {
            $campaign->progress = $campaign->goal_amount > 0
                ? min(100, ($campaign->donations_sum_amount / $campaign->goal_amount) * 100)
                : 0;
        });

        $this->records = $topCampaigns;

        return null;
    }
}
