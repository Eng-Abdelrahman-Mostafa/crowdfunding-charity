<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Models\Campaign;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CampaignResource;

class ListCampaigns extends ListRecords
{
    protected static string $resource = CampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.resource.campaign.create'))
                ->visible(fn (): bool => auth()->user()->can('create', Campaign::class)),
        ];
    }
}
