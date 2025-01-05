<?php

// ListAssociations.php
namespace App\Filament\Resources\AssociationResource\Pages;

use App\Filament\Resources\AssociationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Association;

class ListAssociations extends ListRecords
{
    protected static string $resource = AssociationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.resource.association.create'))
                ->visible(fn (): bool => auth()->user()->can('create', Association::class)),
        ];
    }
}
