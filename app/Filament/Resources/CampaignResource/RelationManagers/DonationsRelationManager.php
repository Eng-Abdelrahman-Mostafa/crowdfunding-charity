<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DonationsRelationManager extends RelationManager
{
    protected static string $relationship = 'donations';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('donor_id')
                            ->relationship('donor', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label(__('filament.resource.donation.donor')),

                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label(__('filament.resource.donation.amount')),

                        Forms\Components\Select::make('currency')
                            ->options([
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                'GBP' => 'GBP',
                            ])
                            ->required()
                            ->label(__('filament.resource.donation.currency')),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => __('filament.resource.donation.statuses.pending'),
                                'success' => __('filament.resource.donation.statuses.success'),
                                'failed' => __('filament.resource.donation.statuses.failed'),
                            ])
                            ->required()
                            ->label(__('filament.resource.donation.status')),

                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'online' => __('filament.resource.donation.payment_methods.online'),
                                'offline' => __('filament.resource.donation.payment_methods.offline'),
                            ])
                            ->required()
                            ->label(__('filament.resource.donation.payment_method')),

                        Forms\Components\TextInput::make('payment_with')
                            ->maxLength(255)
                            ->label(__('filament.resource.donation.payment_with')),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('donor.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.donation.donor')),

                Tables\Columns\TextColumn::make('amount')
                    ->money('currency')
                    ->sortable()
                    ->label(__('filament.resource.donation.amount')),

                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.donation.statuses.{$state}"))
                    ->label(__('filament.resource.donation.status')),

                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.donation.payment_methods.{$state}"))
                    ->label(__('filament.resource.donation.payment_method')),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.donation.created_at')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => __('filament.resource.donation.statuses.pending'),
                        'success' => __('filament.resource.donation.statuses.success'),
                        'failed' => __('filament.resource.donation.statuses.failed'),
                    ])
                    ->label(__('filament.resource.donation.filter_by_status')),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'online' => __('filament.resource.donation.payment_methods.online'),
                        'offline' => __('filament.resource.donation.payment_methods.offline'),
                    ])
                    ->label(__('filament.resource.donation.filter_by_payment_method')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data, string $model): Model {
                        $data['campaign_id'] = $this->ownerRecord->id;
                        return $model::create($data);
                    })
                    ->visible(fn (): bool => auth()->user()->can('create', Donation::class)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn ($record): bool => auth()->user()->can('view', $record)),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => auth()->user()->can('delete', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
