<?php

namespace App\Filament\Resources;

use App\Models\DonationCategory;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\DonationCategoryResource\Pages;

class DonationCategoryResource extends Resource
{
    protected static ?string $model = DonationCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Donation Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.donation_category.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.donation_category.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.donation_category.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.donation_category.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label(__('filament.resource.donation_category.name')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.donation_category.name')),
            ])
            ->filters([
                // You can add filters if needed
            ])
            ->actions([
                EditAction::make()
                    ->label(__('filament.resource.donation_category.edit'))
                    ->visible(fn (DonationCategory $record): bool =>
                    auth()->user()->can('update', $record)),

                DeleteAction::make()
                    ->label(__('filament.resource.donation_category.delete'))
                    ->visible(fn (DonationCategory $record): bool =>
                    auth()->user()->can('delete', $record)),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonationCategories::route('/'),
            'create' => Pages\CreateDonationCategory::route('/create'),
            'edit' => Pages\EditDonationCategory::route('/{record}/edit'),
        ];
    }
}
