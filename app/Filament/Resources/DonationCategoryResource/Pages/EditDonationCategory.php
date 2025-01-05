<?php

namespace App\Filament\Resources\DonationCategoryResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\DonationCategoryResource;

class EditDonationCategory extends EditRecord
{
    protected static string $resource = DonationCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.donation_category.delete'))
                ->visible(fn () => auth()->user()->can('delete', $this->record)),
        ];
    }
}
