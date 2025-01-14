<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpendituresRelationManager extends RelationManager
{
    protected static string $relationship = 'expenditures';

    protected static ?string $title = 'Expenditures';

    public function form(Form $form): Form
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

                        FileUpload::make('receipt')
                            ->image()
                            ->directory('expenditures/receipts')
                            ->visibility('private')
                            ->maxSize(5120)
                            ->label(__('filament.resource.expenditure.receipt')),
                    ]),

                RichEditor::make('description')
                    ->columnSpanFull()
                    ->label(__('filament.resource.expenditure.description')),
            ]);
    }

    public function table(Table $table): Table
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
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataBeforeSave(function (array $data): array {
                        $data['created_by'] = auth()->id();
                        return $data;
                    })
                    ->visible(fn (): bool => auth()->user()->can('create', Expenditure::class)),
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn ($record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn ($record): bool => auth()->user()->can('delete', $record)),
            ])
            ->bulkActions([
                //
            ]);
    }
}
