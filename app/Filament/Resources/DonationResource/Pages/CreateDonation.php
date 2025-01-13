<?php

namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use App\Models\Campaign;
use Filament\Resources\Pages\CreateRecord;

class CreateDonation extends CreateRecord
{
    protected static string $resource = DonationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['paid_at'] = now();
        $data['currency'] = env('APP_CURRENCY', 'EGP');
        $data['payment_status'] = 'success';
        $data['payment_method'] = 'offline';
        $data['created_by'] = auth()->id();

        return $data;
    }
    protected function afterCreate(): void
    {
        // Get the campaign and update its collected_amount
        $campaign = Campaign::find($this->record->campaign_id);
        $campaign->increment('collected_amount', $this->record->amount);
    }
}
