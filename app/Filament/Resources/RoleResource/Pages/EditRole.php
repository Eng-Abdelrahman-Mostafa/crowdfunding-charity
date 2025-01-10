<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Collection;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.role.delete'))
                ->modalHeading(__('filament.resource.role.delete'))
                ->modalDescription(__('filament.resource.role.delete_confirmation')),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get all available permissions from config
        $allPermissions = collect(config('permissions-roles.permissions'))
            ->flatMap(fn ($group) => collect($group)->pluck('name'))
            ->mapWithKeys(fn ($permission) => [$permission => false])
            ->toArray();

        // Get the role's current permissions
        $rolePermissions = $this->record->permissions
            ->pluck('name')
            ->mapWithKeys(fn ($permission) => [$permission => true])
            ->toArray();

        // Merge all permissions with role permissions, prioritizing role permissions
        $data['permissions'] = array_merge($allPermissions, $rolePermissions);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract permissions from the form data and sync them after role update
        $permissions = collect($data['permissions'] ?? [])
            ->filter(fn ($value) => $value)
            ->keys()
            ->toArray();

        // Store permissions in session to be used after update
        session()->put('role_permissions', $permissions);

        // Remove permissions from data as we'll sync them after update
        unset($data['permissions']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Get permissions from session and sync them with the role
        $permissions = session()->get('role_permissions', []);
        $this->record->syncPermissions($permissions);
        session()->forget('role_permissions');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
