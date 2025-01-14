<?php

namespace App\Filament\Resources\ExpenditureResource\Pages;

use App\Filament\Resources\ExpenditureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExpenditures extends ListRecords
{
    protected static string $resource = ExpenditureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.resource.expenditure.create'))
                ->visible(fn (): bool => auth()->user()->can('create', Expenditure::class)),
        ];
    }
}
