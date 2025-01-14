<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenditureResource\Pages\CreateExpenditure;
use App\Filament\Resources\ExpenditureResource\Pages\EditExpenditure;
use App\Filament\Resources\ExpenditureResource\Pages\ListExpenditures;
use App\Models\Expenditure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExpenditureResource extends Resource
{
    protected static ?string $model = Expenditure::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Campaign Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.expenditure.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.expenditure.plural_label');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament.resource.expenditure.navigation_label');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.expenditure.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament.resource.expenditure.name')),

                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->label(__('filament.resource.expenditure.amount')),

                        DatePicker::make('date')
                            ->required()
                            ->maxDate(now())
                            ->label(__('filament.resource.expenditure.date')),

                        Select::make('campaign_id')
                            ->relationship('campaign', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label(__('filament.resource.expenditure.campaign')),

                        // Here's the corrected file upload
                        FileUpload::make('receipt')
                            ->disk('public')
                            ->directory('expenditures/receipts')
                            ->image()
                            ->imageEditor()
                            ->imageEditorViewportWidth('1920')
                            ->imageEditorViewportHeight('1080')
                            ->loadingIndicatorPosition('left')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->label(__('filament.resource.expenditure.receipt')),
                    ]),

                RichEditor::make('description')
                    ->columnSpanFull()
                    ->label(__('filament.resource.expenditure.description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('receipt')
                    ->circular()
                    ->label(__('filament.resource.expenditure.receipt')),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.expenditure.name')),

                TextColumn::make('campaign.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.expenditure.campaign')),

                TextColumn::make('amount')
                    ->money('egp')
                    ->sortable()
                    ->label(__('filament.resource.expenditure.amount')),

                TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label(__('filament.resource.expenditure.date')),

                TextColumn::make('user.name')
                    ->label(__('filament.resource.expenditure.created_by')),
            ])
            ->filters([
                SelectFilter::make('campaign')
                    ->relationship('campaign', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('filament.resource.expenditure.filter_by_campaign')),

                Filter::make('date')
                    ->form([
                        DatePicker::make('from_date')
                            ->label(__('filament.resource.expenditure.from_date')),
                        DatePicker::make('to_date')
                            ->label(__('filament.resource.expenditure.to_date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['to_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->label(__('filament.resource.expenditure.filter_by_date')),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->label(__('filament.resource.expenditure.edit'))
                        ->visible(fn (Expenditure $record): bool => auth()->user()->can('update', $record)),

                    DeleteAction::make()
                        ->label(__('filament.resource.expenditure.delete'))
                        ->visible(fn (Expenditure $record): bool => auth()->user()->can('delete', $record)),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If user is association manager, only show expenditures for their campaigns
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
            'index' => ListExpenditures::route('/'),
            'create' => CreateExpenditure::route('/create'),
            'edit' => EditExpenditure::route('/{record}/edit'),
        ];
    }
}
