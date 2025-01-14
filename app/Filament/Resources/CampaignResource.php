<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\RelationManagers\DonationsRelationManager;
use App\Filament\Resources\CampaignResource\RelationManagers\ExpendituresRelationManager;
use App\Models\Campaign;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\CampaignResource\Pages;
use Filament\Forms\Components\FileUpload;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Campaign Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.campaign.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.campaign.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.campaign.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.campaign.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('campaigns/thumbnails')
                                    ->visibility('public')
                                    ->label(__('filament.resource.campaign.thumbnail')),

                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('filament.resource.campaign.name')),

                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull()
                                    ->label(__('filament.resource.campaign.description')),

                                Forms\Components\TextInput::make('address')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('filament.resource.campaign.address')),
                            ]),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'active' => __('filament.resource.campaign.statuses.active'),
                                        'inactive' => __('filament.resource.campaign.statuses.inactive'),
                                    ])
                                    ->required()
                                    ->label(__('filament.resource.campaign.status')),

                                Forms\Components\TextInput::make('goal_amount')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->label(__('filament.resource.campaign.goal_amount')),

                                Forms\Components\Select::make('donation_type')
                                    ->options([
                                        'open' => __('filament.resource.campaign.donation_types.open'),
                                        'share' => __('filament.resource.campaign.donation_types.share'),
                                    ])
                                    ->required()
                                    ->reactive()
                                    ->label(__('filament.resource.campaign.donation_type')),

                                Forms\Components\TextInput::make('share_amount')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(fn (callable $get) => $get('donation_type') === 'share')
                                    ->visible(fn (callable $get) => $get('donation_type') === 'share')
                                    ->rules([
                                        function (callable $get) {
                                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                                if ($get('donation_type') === 'share' && $value >= $get('goal_amount')) {
                                                    $fail(__('filament.resource.campaign.validation.share_amount_less_than_goal'));
                                                }
                                            };
                                        },
                                    ])
                                    ->label(__('filament.resource.campaign.share_amount')),

                                Forms\Components\DatePicker::make('start_date')
                                    ->required()
                                    ->label(__('filament.resource.campaign.start_date')),

                                Forms\Components\DatePicker::make('end_date')
                                    ->required()
                                    ->after('start_date')
                                    ->label(__('filament.resource.campaign.end_date')),

                                Forms\Components\Select::make('association_id')
                                    ->relationship('association', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->label(__('filament.resource.campaign.association')),

                                Forms\Components\Select::make('donation_category_id')
                                    ->relationship('donationCategory', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->label(__('filament.resource.campaign.category')),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->circular()
                    ->label(__('filament.resource.campaign.thumbnail')),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.campaign.name')),

                TextColumn::make('association.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.campaign.association')),

                TextColumn::make('donationCategory.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.campaign.category')),

                TextColumn::make('goal_amount')
                    ->money('egp')
                    ->sortable()
                    ->label(__('filament.resource.campaign.goal_amount')),

                TextColumn::make('collected_amount')
                    ->money('egp')
                    ->sortable()
                    ->label(__('filament.resource.campaign.collected_amount')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.campaign.statuses.{$state}"))
                    ->label(__('filament.resource.campaign.status')),

                TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->label(__('filament.resource.campaign.start_date')),

                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label(__('filament.resource.campaign.end_date')),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => __('filament.resource.campaign.statuses.active'),
                        'inactive' => __('filament.resource.campaign.statuses.inactive'),
                    ])
                    ->label(__('filament.resource.campaign.filter_by_status')),

                SelectFilter::make('donation_type')
                    ->options([
                        'open' => __('filament.resource.campaign.donation_types.open'),
                        'share' => __('filament.resource.campaign.donation_types.share'),
                    ])
                    ->label(__('filament.resource.campaign.filter_by_donation_type')),

                SelectFilter::make('association_id')
                    ->relationship('association', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('filament.resource.campaign.filter_by_association')),

                SelectFilter::make('donation_category_id')
                    ->relationship('donationCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('filament.resource.campaign.filter_by_category')),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view_expenditures')
                        ->icon('heroicon-o-banknotes')
                        ->label(__('filament.resource.campaign.view_expenditures'))
                        ->url(fn (Campaign $record): string =>
                        ExpenditureResource::getUrl('index', [
                            'tableFilters[campaign][value]' => $record->id
                        ])
                        )
                        ->visible(fn (Campaign $record): bool =>
                        auth()->user()->can('viewAny', Expenditure::class)
                        ),

                    Action::make('toggle_status')
                        ->icon('heroicon-o-power')
                        ->label(__('filament.resource.campaign.toggle_status'))
                        ->requiresConfirmation()
                        ->action(fn (Campaign $record) => $record->update([
                            'status' => $record->status === 'active' ? 'inactive' : 'active'
                        ]))
                        ->visible(fn (Campaign $record): bool =>
                        auth()->user()->can('changeStatus', $record)
                        ),

                    EditAction::make()
                        ->label(__('filament.resource.campaign.edit'))
                        ->visible(fn (Campaign $record): bool =>
                        auth()->user()->can('update', $record)
                        ),

                    DeleteAction::make()
                        ->label(__('filament.resource.campaign.delete'))
                        ->visible(fn (Campaign $record): bool =>
                        auth()->user()->can('delete', $record)
                        ),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            DonationsRelationManager::class,
            ExpendituresRelationManager::class,
        ];
    }
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        // If user is association manager, only show donations for their associations
        if (!auth()->user()->hasRole('super-admin')) {
            $query->whereIn('association_id', auth()->user()->associations->pluck('id'));
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
