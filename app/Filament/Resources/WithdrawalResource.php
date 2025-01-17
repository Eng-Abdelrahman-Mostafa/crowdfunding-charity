<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Models\Campaign;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Financial Management';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('filament.resource.withdrawal.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.withdrawal.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.withdrawal.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.withdrawal.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('association_id')
                            ->relationship(
                                'association',
                                'name',
                                function (Builder $query) {
                                    if (auth()->user()->type !== 'admin') {
                                        return $query->whereIn('id', auth()->user()->associations->pluck('id'));
                                    }
                                    return $query;
                                }
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (callable $set) {
                                $set('campaign_id', null);
                                $set('available_balance', null);
                            })
                            ->label(__('filament.resource.withdrawal.association')),

                        Select::make('campaign_id')
                            ->relationship(
                                'campaign',
                                'name',
                                function (Builder $query, callable $get) {
                                    $query = $query->where('association_id', $get('association_id'))
                                        ->where('status', 'active')
                                        ->whereDate('end_date', '>=', now());

                                    if (auth()->user()->type !== 'admin') {
                                        $query->whereIn('association_id', auth()->user()->associations->pluck('id'));
                                    }

                                    return $query;
                                }
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $campaign = Campaign::with(['withdrawals' => function ($query) {
                                        $query->whereIn('status', ['success', 'pending']);
                                    }])->find($state);

                                    if ($campaign) {
                                        $availableBalance = $campaign->collected_amount - $campaign->withdrawals->sum('amount');
                                        $set('available_balance', $availableBalance);
                                    }
                                } else {
                                    $set('available_balance', null);
                                }
                            })
                            ->label(__('filament.resource.withdrawal.campaign')),

                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label(__('filament.resource.withdrawal.amount'))
                            ->hint(fn (callable $get) => $get('available_balance') !== null
                                ? __('filament.resource.withdrawal.available_balance', [
                                    'amount' => number_format($get('available_balance'), 2)
                                ])
                                : null)
                            ->helperText(__('filament.resource.withdrawal.amount_helper'))
                            ->live()
                            ->rules([
                                'required',
                                'numeric',
                                'min:1',
                                function (callable $get) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get) {
                                        $availableBalance = $get('available_balance');
                                        if ($availableBalance !== null && $value > $availableBalance) {
                                            $fail(__('filament.resource.withdrawal.validation.amount_exceeds_balance', [
                                                'available' => number_format($availableBalance, 2)
                                            ]));
                                        }
                                    };
                                },
                            ]),

                        Hidden::make('available_balance'),

                        Textarea::make('note')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->label(__('filament.resource.withdrawal.note')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('association.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.association')),

                TextColumn::make('campaign.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.campaign'))
                    ->formatStateUsing(fn ($state, Withdrawal $record) =>
                    $record->campaign ? $record->campaign->name : '-'),

                TextColumn::make('amount')
                    ->money('egp')
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.amount')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.withdrawal.statuses.{$state}"))
                    ->label(__('filament.resource.withdrawal.status')),

                TextColumn::make('requester.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.requester')),

                TextColumn::make('processor.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.processor')),

                TextColumn::make('requested_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.requested_at')),

                TextColumn::make('processed_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.withdrawal.processed_at')),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => __('filament.resource.withdrawal.statuses.pending'),
                        'success' => __('filament.resource.withdrawal.statuses.success'),
                        'failed' => __('filament.resource.withdrawal.statuses.failed'),
                    ])
                    ->label(__('filament.resource.withdrawal.filter_by_status')),

                SelectFilter::make('association')
                    ->relationship('association', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('filament.resource.withdrawal.filter_by_association')),

                Filter::make('requested_at')
                    ->form([
                        DateTimePicker::make('requested_from')
                            ->label(__('filament.resource.withdrawal.from_date')),
                        DateTimePicker::make('requested_until')
                            ->label(__('filament.resource.withdrawal.to_date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['requested_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('requested_at', '>=', $date),
                            )
                            ->when(
                                $data['requested_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('requested_at', '<=', $date),
                            );
                    })
                    ->label(__('filament.resource.withdrawal.filter_by_date')),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label(__('filament.resource.withdrawal.view'))
                        ->modalHeading(fn (Withdrawal $record) => __('filament.resource.withdrawal.view_title', ['id' => $record->id]))
                        ->visible(fn (Withdrawal $record): bool => auth()->user()->can('view', $record)),

                    Action::make('approve')
                        ->label(__('filament.resource.withdrawal.approve'))
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading(__('filament.resource.withdrawal.approve'))
                        ->modalDescription(__('filament.resource.withdrawal.approve_confirmation'))
                        ->successNotification(
                            notification: fn () => \Filament\Notifications\Notification::make()
                                ->success()
                                ->title(__('filament.resource.withdrawal.approved'))
                        )
                        ->action(function (Withdrawal $record) {
                            app(WithdrawalService::class)->approveRequest($record, auth()->user());
                        })
                        ->visible(fn (Withdrawal $record): bool =>
                            $record->status === 'pending' &&
                            auth()->user()->can('approve', $record)
                        ),

                    Action::make('reject')
                        ->label(__('filament.resource.withdrawal.reject'))
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading(__('filament.resource.withdrawal.reject'))
                        ->modalDescription(__('filament.resource.withdrawal.reject_confirmation'))
                        ->successNotification(
                            notification: fn () => \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title(__('filament.resource.withdrawal.rejected'))
                        )
                        ->form([
                            Textarea::make('rejection_note')
                                ->label(__('filament.resource.withdrawal.rejection_note'))
                                ->required(),
                        ])
                        ->action(function (Withdrawal $record, array $data) {
                            app(WithdrawalService::class)->rejectRequest($record, auth()->user(), $data['rejection_note']);
                        })
                        ->visible(fn (Withdrawal $record): bool =>
                            $record->status === 'pending' &&
                            auth()->user()->can('reject', $record)
                        ),
                ]),
            ])
            ->defaultSort('requested_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['association', 'campaign']); // Eager load relationships

        // If user is association manager, only show withdrawals for their associations
        if (!auth()->user()->hasRole('super-admin')) {
            $query->whereHas('association', function ($query) {
                $query->whereIn('id', auth()->user()->associations->pluck('id'));
            });
        }

        return $query;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
        ];
    }
}
