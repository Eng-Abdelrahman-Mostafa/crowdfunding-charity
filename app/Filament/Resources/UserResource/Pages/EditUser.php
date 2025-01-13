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
        // Remove password fields if they're empty
        if (empty($data['password'])) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Handle password separately
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        unset($data['password_confirmation']);

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

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.user.delete'))
                ->visible(fn () => auth()->user()->can('delete', $this->record)),
        ];
    }
}
