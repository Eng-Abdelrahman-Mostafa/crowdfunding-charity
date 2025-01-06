<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    public static function getModelLabel(): string
    {
        return __('filament.resource.user.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resource.user.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resource.user.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resource.user.navigation_group');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'gray';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('filament.resource.user.name')),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label(__('filament.resource.user.email')),

                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255)
                    ->label(__('filament.resource.user.phone')),

                TextInput::make('password')
                    ->password()
                    ->required(fn ($component, $get, $record) => ! $record)
                    ->minLength(8)
                    ->same('password_confirmation')
                    ->label(__('filament.resource.user.password')),

                TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn ($component, $get, $record) => ! $record)
                    ->minLength(8)
                    ->label(__('filament.resource.user.password_confirmation')),

                Select::make('type')
                    ->options([
                        'admin' => __('filament.resource.user.types.admin'),
                        'association_manager' => __('filament.resource.user.types.association_manager'),
                        'donor' => __('filament.resource.user.types.donor'),
                    ])
                    ->required()
                    ->live()
                    ->label(__('filament.resource.user.type')),

                Select::make('status')
                    ->options([
                        'active' => __('filament.resource.user.statuses.active'),
                        'inactive' => __('filament.resource.user.statuses.inactive'),
                    ])
                    ->required()
                    ->default('active')
                    ->label(__('filament.resource.user.status')),

                Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->visible(fn (callable $get) =>
                    in_array($get('type'), ['admin', 'association_manager']))
                    ->required(fn (callable $get) =>
                    in_array($get('type'), ['admin', 'association_manager']))
                    ->label(__('filament.resource.user.roles')),

                Select::make('associations')
                    ->multiple()
                    ->relationship('associations', 'name')
                    ->preload()
                    ->visible(fn (callable $get) => $get('type') === 'association_manager')
                    ->required(fn (callable $get) => $get('type') === 'association_manager')
                    ->label(__('filament.resource.user.associations')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.user.name'))
                    ->url(fn ($record) => $record->trashed() ? null : static::getUrl('edit', ['record' => $record])),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament.resource.user.email')),

                TextColumn::make('phone')
                    ->searchable()
                    ->label(__('filament.resource.user.phone')),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'primary',
                        'association_manager' => 'warning',
                        'donor' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.user.types.{$state}"))
                    ->label(__('filament.resource.user.type')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.resource.user.statuses.{$state}"))
                    ->label(__('filament.resource.user.status')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament.resource.user.created_at')),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'admin' => __('filament.resource.user.types.admin'),
                        'association_manager' => __('filament.resource.user.types.association_manager'),
                        'donor' => __('filament.resource.user.types.donor'),
                    ])
                    ->label(__('filament.resource.user.filter_by_type')),

                SelectFilter::make('status')
                    ->options([
                        'active' => __('filament.resource.user.statuses.active'),
                        'inactive' => __('filament.resource.user.statuses.inactive'),
                    ])
                    ->label(__('filament.resource.user.filter_by_status')),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label(__('filament.resource.user.from_date')),
                        DatePicker::make('created_until')
                            ->label(__('filament.resource.user.to_date')),
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
                    ->label(__('filament.resource.user.filter_by_date')),
            ])
            ->actions([
                // Inside the table() method, in the actions section
                Action::make('restore')
                    ->label(__('filament.resource.user.restore'))
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(__('filament.resource.user.restore'))
                    ->modalDescription(__('filament.resource.user.Are_you_sure_you_want_to_restore_this_user?'))
                    ->action(fn (User $user) => $user->restore())
                    ->successNotification(
                        notification: fn () => \Filament\Notifications\Notification::make()
                            ->success()
                            ->title(__('filament.resource.user.restored'))
                    )
                    ->visible(fn (User $record): bool =>
                        $record->trashed() &&
                        auth()->user()->can('restore', $record)),

                Action::make('toggle_status')
                    ->label(__('filament.resource.user.toggle_status'))
                    ->icon('heroicon-o-power')
                    ->requiresConfirmation()
                    ->modalHeading(__('filament.resource.user.toggle_status'))
                    ->modalDescription(fn (User $record) =>
                    $record->status === 'active'
                        ? __('filament.resource.user.Are_you_sure_you_want_to_deactivate_this_user?')
                        : __('filament.resource.user.Are_you_sure_you_want_to_activate_this_user?'))
                    ->action(function(User $user) {
                        $user->update([
                            'status' => $user->status === 'active' ? 'inactive' : 'active'
                        ]);
                    })
                    ->successNotification(
                        notification: fn () => \Filament\Notifications\Notification::make()
                            ->success()
                            ->title(__('filament.resource.user.status_updated'))
                    )
                    ->visible(fn (User $user): bool =>
                        !$user->trashed() &&
                        auth()->user()->can('changeStatus', $user)),

                EditAction::make()
                    ->label(__('filament.resource.user.edit'))
                    ->visible(fn (User $user): bool =>
                        !$user->trashed() &&
                        auth()->user()->can('update', $user)),

                Action::make('forceDelete')
                    ->label(__('filament.resource.user.force_delete'))
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('filament.resource.user.force_delete'))
                    ->modalDescription(__('filament.resource.user.Are_you_sure_you_want_to_permanently_delete_this_user?'))
                    ->action(fn (User $user) => $user->forceDelete())
                    ->successNotification(
                        notification: fn () => \Filament\Notifications\Notification::make()
                            ->success()
                            ->title(__('filament.resource.user.permanently_deleted'))
                    )
                    ->visible(fn (User $record): bool =>
                        $record->trashed() &&
                        auth()->user()->can('forceDelete', $record)),

                DeleteAction::make()
                    ->label(__('filament.resource.user.delete'))
                    ->modalHeading(__('filament.resource.user.delete'))
                    ->modalDescription(__('filament.resource.user.Are_you_sure_you_want_to_delete_this_user?'))
                    ->visible(fn (User $user): bool =>
                        !$user->trashed() &&
                        auth()->user()->can('delete', $user)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
