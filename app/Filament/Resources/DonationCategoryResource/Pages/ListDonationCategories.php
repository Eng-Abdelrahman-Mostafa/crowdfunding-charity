<?php

namespace App\Filament\Resources\DonationCategoryResource\Pages;

use App\Models\DonationCategory;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DonationCategoryResource;

class ListDonationCategories extends ListRecords
{
    protected static string $resource = DonationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.resource.donation_category.create'))
                ->visible(fn (): bool => auth()->user()->can('create', DonationCategory::class)),
        ];
    }
}
