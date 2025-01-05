<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormData(array $data): array
    {
        // Hash the password
        $data['password'] = Hash::make($data['password']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Create the user
        $user = static::getModel()::create($data);

        // Assign roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        // Attach associations if user is association manager
        if ($user->isAssociationManager() && isset($data['associations'])) {
            $user->associations()->sync($data['associations']);
        }

        return $user;
    }

    protected function beforeCreate(): void
    {
        // Add any additional validation or checks before creation
    }

    protected function afterCreate(): void
    {
        // Add any additional logic after user creation
        // For example, sending welcome email, etc.
    }
}
