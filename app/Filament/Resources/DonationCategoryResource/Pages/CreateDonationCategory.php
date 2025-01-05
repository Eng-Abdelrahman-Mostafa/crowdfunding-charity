<?php

namespace App\Filament\Resources\DonationCategoryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DonationCategoryResource;

class CreateDonationCategory extends CreateRecord
{
    protected static string $resource = DonationCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormData(array $data): array
    {
        return $data;
    }
}
