<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CampaignResource;
use Illuminate\Database\Eloquent\Model;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormData(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['collected_amount'] = 0;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Ensure created_by is set
        $data['created_by'] = auth()->id();

        // Create the campaign
        $campaign = static::getModel()::create($data);

        // Handle thumbnail upload
        if (isset($data['thumbnail'])) {
            $campaign->copyMediaFromDisk($data['thumbnail'], 'public', 'thumbnail');
        }

        return $campaign;
    }
}
