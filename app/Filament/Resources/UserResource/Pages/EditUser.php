<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormData(array $data): array
    {
        // Only hash the password if it's being updated
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // If password field is empty, remove it from the data array
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        // Load the existing roles for the user
        if (in_array($this->record->type, ['admin', 'association_manager'])) {
            $data['roles'] = $this->record->roles->pluck('id')->toArray();
        }

        // Load the existing associations for association managers
        if ($this->record->type === 'association_manager') {
            $data['associations'] = $this->record->associations->pluck('id')->toArray();
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update basic user data
        $record->update($data);

        // Sync roles if user is admin or association manager
        if (in_array($record->type, ['admin', 'association_manager']) && isset($data['roles'])) {
            $record->syncRoles($data['roles']);
        }

        // Sync associations if user is association manager
        if ($record->type === 'association_manager' && isset($data['associations'])) {
            $record->associations()->sync($data['associations']);
        } elseif ($record->type !== 'association_manager') {
            // If user is no longer an association manager, remove all associations
            $record->associations()->detach();
        }

        return $record;
    }

    protected function beforeSave(): void
    {
        // Add any additional validation or checks before saving
    }

    protected function afterSave(): void
    {
        // Add any notifications or additional logic after saving
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.user.delete'))
                ->visible(fn () => auth()->user()->can('delete', $this->record)),
        ];
    }
}
