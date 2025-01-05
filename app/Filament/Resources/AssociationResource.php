<?php

namespace App\Filament\Resources;

use App\Models\Association;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\AssociationResource\Pages;

class AssociationResource extends Resource
{
    protected static ?string $model = Association::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Association Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.association.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.association.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.association.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.association.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('associations/logos') // Specify directory
                            ->disk('public') // Specify disk
                            ->visibility('public')
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->label(__('filament.resource.association.logo')),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('filament.resource.association.name')),

                                Forms\Components\TextInput::make('website')
                                    ->url()
                                    ->maxLength(255)
                                    ->label(__('filament.resource.association.website')),

                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('filament.resource.association.email')),

                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('filament.resource.association.phone')),
                            ]),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament.resource.association.address')),

                        Forms\Components\TextInput::make('city')
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament.resource.association.city')),

                        Forms\Components\TextInput::make('state')
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament.resource.association.state')),

                        Forms\Components\TextInput::make('zip')
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament.resource.association.zip')),

                        Forms\Components\TextInput::make('country')
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament.resource.association.country')),

                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => __('filament.resource.association.statuses.active'),
                                'inactive' => __('filament.resource.association.statuses.inactive'),
                            ])
                            ->required()
                            ->label(__('filament.resource.association.status')),
                    ]),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->label(__('filament.resource.association.description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->circular()
                    ->label(__('filament.resource.association.logo')),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.association.name')),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.association.email')),

                TextColumn::make('phone')
                    ->searchable()
                    ->label(__('filament.resource.association.phone')),

                TextColumn::make('city')
                    ->searchable()
                    ->label(__('filament.resource.association.city')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.association.statuses.$state"))
                    ->label(__('filament.resource.association.status')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.association.created_at')),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => __('filament.resource.association.statuses.active'),
                        'inactive' => __('filament.resource.association.statuses.inactive'),
                    ])
                    ->label(__('filament.resource.association.filter_by_status')),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('filament.resource.association.from_date')),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('filament.resource.association.to_date')),
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
                    ->label(__('filament.resource.association.filter_by_date')),
            ])
            ->actions([
                Action::make('toggle_status')
                    ->icon('heroicon-o-power')
                    ->requiresConfirmation()
                    ->action(fn (Association $record) => $record->update([
                        'status' => $record->status === 'active' ? 'inactive' : 'active'
                    ]))
                    ->successNotification(
                        notification: fn () => \Filament\Notifications\Notification::make()
                            ->success()
                            ->title(__('filament.resource.association.status_updated'))
                    )
                    ->label(__('filament.resource.association.toggle_status'))
                    ->visible(fn (Association $record): bool => auth()->user()->can('changeStatus', $record)),

                EditAction::make()
                    ->label(__('filament.resource.association.edit'))
                    ->visible(fn (Association $record): bool => auth()->user()->can('update', $record)),

                DeleteAction::make()
                    ->label(__('filament.resource.association.delete'))
                    ->visible(fn (Association $record): bool => auth()->user()->can('delete', $record)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssociations::route('/'),
            'create' => Pages\CreateAssociation::route('/create'),
            'edit' => Pages\EditAssociation::route('/{record}/edit'),
        ];
    }
}
