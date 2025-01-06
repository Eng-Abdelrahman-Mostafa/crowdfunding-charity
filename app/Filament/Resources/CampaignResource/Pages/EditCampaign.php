<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CampaignResource;
use Illuminate\Database\Eloquent\Model;

class EditCampaign extends EditRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormData(array $data): array
    {
        if ($this->record->hasMedia('thumbnail')) {
            $data['thumbnail'] = $this->record->getFirstMediaUrl('thumbnail');
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if (isset($data['thumbnail']) && $data['thumbnail'] !== $record->getFirstMediaUrl('thumbnail')) {
            $record->clearMediaCollection('thumbnail');
            $record->addMediaFromDisk($data['thumbnail'], 'public')
                ->toMediaCollection('thumbnail');
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('filament.resource.campaign.delete'))
                ->visible(fn () => auth()->user()->can('delete', $this->record)),
        ];
    }
}
