<?php

// CreateAssociation.php
namespace App\Filament\Resources\AssociationResource\Pages;

use App\Filament\Resources\AssociationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAssociation extends CreateRecord
{
    protected static string $resource = AssociationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['created_by'] = auth()->id();

        $record = static::getModel()::create($data);

        if (isset($data['logo'])) {
            $record->addMediaFromDisk($data['logo'], 'public')
                ->toMediaCollection('logo');
        }

        return $record;
    }
}
