<?php

namespace App\Filament\Widgets;

use App\Services\DashboardService;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AssociationManagerRecentWithdrawalsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Withdrawals';

    protected static ?int $sort = 7;

    protected int | string | array $columnSpan = 6;
    public ?Collection $records = null;

    protected function getTableQuery(): Builder
    {
        // This is a placeholder. We're not actually using this method directly.
        // Instead, we're manually loading data in getTableContent().
        return \App\Models\Withdrawal::query()->limit(0);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('association.name')
                ->label(__('Association'))
                ->searchable(),

            TextColumn::make('campaign.name')
                ->label(__('Campaign'))
                ->searchable(),

            TextColumn::make('amount')
                ->label(__('Amount'))
                ->money(config('app.currency', 'EGP')),

            TextColumn::make('status')
                ->label(__('Status'))
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'success' => 'success',
                    'failed' => 'danger',
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => __('Pending'),
                    'success' => __('Success'),
                    'failed' => __('Failed'),
                    default => $state,
                }),

            TextColumn::make('created_at')
                ->label(__('Date'))
                ->dateTime()
                ->sortable(),
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

        $recentWithdrawals = $dashboardService->getRecentWithdrawals($associationIds);

        $this->records = $recentWithdrawals;

        return null;
    }
}
