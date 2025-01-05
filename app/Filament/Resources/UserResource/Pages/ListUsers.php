<?php

namespace App\Filament\Resources\UserResource\Pages;


use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public bool $showTrashedUsers = false;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.resource.user.create'))
                ->icon('heroicon-o-plus')
                ->visible(fn(): bool => auth()->user()->can('create', User::class)),

            Action::make('toggle_trashed')
                ->label(fn() => $this->showTrashedUsers
                    ? __('filament.resource.user.show_active')
                    : __('filament.resource.user.show_deleted'))
                ->icon(fn() => $this->showTrashedUsers
                    ? 'heroicon-o-user-group'
                    : 'heroicon-o-trash')
                ->action(function () {
                    $this->showTrashedUsers = !$this->showTrashedUsers;
                    $this->tableFilters = [];
                    $this->resetTable();
                })
                ->color(fn() => $this->showTrashedUsers ? 'danger' : 'gray')
                ->visible(fn(): bool => auth()->user()->can('viewAny', User::class)),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        return $this->showTrashedUsers
            ? $query->onlyTrashed()
            : $query->withoutTrashed();
    }

    public function getTitle(): string
    {
        return $this->showTrashedUsers
            ? __('filament.resource.user.show_deleted')
            : parent::getTitle();
    }
}
