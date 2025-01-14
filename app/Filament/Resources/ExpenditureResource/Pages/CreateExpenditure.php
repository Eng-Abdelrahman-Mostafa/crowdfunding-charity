<?php

namespace App\Filament\Resources\ExpenditureResource\Pages;

use App\Filament\Resources\ExpenditureResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateExpenditure extends CreateRecord
{
    protected static string $resource = ExpenditureResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function handleRecordCreation(array $data): Model
    {
        // Ensure created_by is set
        $data['created_by'] = auth()->id();

        // Create the expenditure
        $expenditure = static::getModel()::create($data);

        // Handle receipt upload
        if (isset($data['receipt'])) {
            $expenditure->addMediaFromDisk($data['receipt'], 'public')
                ->toMediaCollection('receipt');
        }

        return $expenditure;
    }
}
