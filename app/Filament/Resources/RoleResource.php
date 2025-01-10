<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Checkbox;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'User Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.role.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.role.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.role.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.role.navigation_group');
    }

    public static function form(Form $form): Form
    {
        $permissionsByGroup = collect(config('permissions-roles.permissions'))
            ->mapWithKeys(fn ($permissions, $group) => [
                $group => collect($permissions)->pluck('name')
            ]);

        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->label(__('filament.resource.role.name')),

                                TextInput::make('guard_name')
                                    ->default('web')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->label(__('filament.resource.role.guard_name')),
                            ]),

                        Section::make(__('filament.resource.role.permissions'))
                            ->schema([
                                Tabs::make('Permissions')
                                    ->tabs(
                                        $permissionsByGroup->map(fn ($permissions, $group) =>
                                        Tab::make(ucfirst($group))
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema(
                                                        collect($permissions)->map(fn ($permission) =>
                                                        Checkbox::make("permissions.{$permission}")
                                                            ->label(__("filament.resource.role.permissions_groups.{$group}." . str_replace(["{$group}_", '_'], ['', ' '], $permission)))
                                                            ->inline()
                                                        )->toArray()
                                                    ),
                                            ])
                                        )->toArray()
                                    )
                                    ->columnSpan('full'),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('filament.resource.role.id')),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.role.name')),

                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label(__('filament.resource.role.permissions_count')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.role.created_at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label(__('filament.resource.role.edit')),
                DeleteAction::make()
                    ->label(__('filament.resource.role.delete'))
                    ->visible(fn (Role $record) => $record->name !== 'super-admin')
                    ->modalHeading(__('filament.resource.role.delete'))
                    ->modalDescription(__('filament.resource.role.delete_confirmation')),
            ])
            ->defaultSort('id', 'desc')
            ->deferLoading();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('name', '!=', 'super-admin');
    }
}
