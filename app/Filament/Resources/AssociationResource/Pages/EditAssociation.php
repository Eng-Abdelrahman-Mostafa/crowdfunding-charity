<?php

// EditAssociation.php
namespace App\Filament\Resources\AssociationResource\Pages;

use App\Filament\Resources\AssociationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAssociation extends EditRecord
{
    protected static string $resource = AssociationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormData(array $data): array
    {
        if ($this->record->hasMedia('logo')) {
            $data['logo'] = $this->record->getFirstMediaUrl('logo');
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if (isset($data['logo']) && $data['logo'] !== $record->getFirstMediaUrl('logo')) {
            $record->clearMediaCollection('logo');
            $record->addMediaFromDisk($data['logo'], 'public')
                ->toMediaCollection('logo');
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.association.delete'))
                ->visible(fn () => auth()->user()->can('delete', $this->record)),
        ];
    }
}
