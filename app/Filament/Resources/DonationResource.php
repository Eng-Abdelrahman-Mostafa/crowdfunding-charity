<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Models\Donation;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Donation Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.donation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.donation.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.donation.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.donation.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('donor_id')
                            ->relationship('donor', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label(__('filament.resource.donation.donor')),

                        Select::make('campaign_id')
                            ->relationship('campaign', 'name', function ($query) {
                                return $query->where('status', 'active')
                                    ->whereDate('end_date', '>', now())
                                    ->orderBy('name');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $campaign = \App\Models\Campaign::find($state);
                                    if ($campaign && $campaign->donation_type === 'share') {
                                        $set('amount', $campaign->share_amount);
                                    }
                                }
                            })
                            ->label(__('filament.resource.donation.campaign')),

                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->dehydrated()
                            ->disabled(function ($get) {
                                $campaign = \App\Models\Campaign::find($get('campaign_id'));
                                return $campaign && $campaign->donation_type === 'share';
                            })
                            ->rule(function ($get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $campaign = \App\Models\Campaign::find($get('campaign_id'));
                                    if (!$campaign) return;

                                    $remainingGoal = $campaign->goal_amount - $campaign->collected_amount;

                                    if ($value > $remainingGoal) {
                                        $fail(__('filament.resource.donation.validation.amount_exceeds_remaining_goal', [
                                            'remaining' => $remainingGoal
                                        ]));
                                    }
                                };
                            })
                            ->label(__('filament.resource.donation.amount')),
                    Hidden::make('payment_status'),
                    Hidden::make('payment_method'),
                    Hidden::make('currency'),

                    DateTimePicker::make('due_date')
                        ->label(__('filament.resource.donation.due_date')),

                    FileUpload::make('attachments')
                        ->multiple()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.ms-excel', 'text/plain', 'image/*'])
                        ->directory('donations/attachments')
                        ->visibility('private')
                        ->label(__('filament.resource.donation.attachments')),
                ]),
        ]);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('donor.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.donation.donor')),

                TextColumn::make('campaign.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.donation.campaign')),

                TextColumn::make('amount')
                    ->money(\env('APP_CURRENCY', 'EGP'))
                    ->sortable()
                    ->label(__('filament.resource.donation.amount')),

                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.donation.statuses.{$state}"))
                    ->label(__('filament.resource.donation.status')),

                TextColumn::make('payment_method')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.donation.payment_methods.{$state}"))
                    ->label(__('filament.resource.donation.payment_method')),

                TextColumn::make('payment_with')
                    ->searchable()
                    ->label(__('filament.resource.donation.payment_with')),

                TextColumn::make('paid_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.donation.paid_at')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.donation.created_at')),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->options([
                        'pending' => __('filament.resource.donation.statuses.pending'),
                        'success' => __('filament.resource.donation.statuses.success'),
                        'failed' => __('filament.resource.donation.statuses.failed'),
                    ])
                    ->label(__('filament.resource.donation.filter_by_status')),

                SelectFilter::make('payment_method')
                    ->options([
                        'online' => __('filament.resource.donation.payment_methods.online'),
                        'offline' => __('filament.resource.donation.payment_methods.offline'),
                    ])
                    ->label(__('filament.resource.donation.filter_by_payment_method')),

                SelectFilter::make('campaign')
                    ->relationship('campaign', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('filament.resource.donation.filter_by_campaign')),

                Filter::make('created_at')
                    ->form([
                        DateTimePicker::make('created_from')
                            ->label(__('filament.resource.donation.from_date')),
                        DateTimePicker::make('created_until')
                            ->label(__('filament.resource.donation.to_date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->label(__('filament.resource.donation.filter_by_date')),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label(__('filament.resource.donation.view'))
                        ->modalHeading(fn (Donation $record): string => __('filament.resource.donation.view_title', ['name' => $record->donor->name]))
                        ->visible(fn (Donation $record): bool => auth()->user()->can('view', $record)),

                    DeleteAction::make()
                        ->label(__('filament.resource.donation.delete'))
                        ->visible(fn (Donation $record): bool => auth()->user()->can('delete', $record)),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If user is association manager, only show donations for their associations
        if (!auth()->user()->hasRole('super-admin')) {
            $query->whereHas('campaign.association', function ($query) {
                $query->whereIn('id', auth()->user()->associations->pluck('id'));
            });
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
        ];
    }
}
