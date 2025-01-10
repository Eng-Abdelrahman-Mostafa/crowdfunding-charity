<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract permissions from the form data and sync them after role creation
        $permissions = collect($data['permissions'] ?? [])
            ->filter(fn ($value) => $value)
            ->keys()
            ->toArray();

        // Remove permissions from data as we'll sync them after role creation
        unset($data['permissions']);

        // Store permissions in session to be used after creation
        session()->put('role_permissions', $permissions);

        return $data;
    }

    protected function afterCreate(): void
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
