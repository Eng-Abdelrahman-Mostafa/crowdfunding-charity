<?php

namespace App\Filament\Resources\ExpenditureResource\Pages;

use App\Filament\Resources\ExpenditureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditExpenditure extends EditRecord
{
    protected static string $resource = ExpenditureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.expenditure.delete')),
        ];
    }
    protected function mutateFormData(array $data): array
    {
        if ($this->record->hasMedia('receipt')) {
            $data['receipt'] = $this->record->getFirstMediaUrl('receipt');
        }

        return $data;
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if (isset($data['receipt']) && $data['receipt'] !== $record->getFirstMediaUrl('thumbnail')) {
            $record->clearMediaCollection('receipt');
            $record->addMediaFromDisk($data['receipt'], 'public')
                ->toMediaCollection('receipt');
        }

        return $record;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
