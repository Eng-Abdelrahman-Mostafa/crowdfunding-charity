<?php

namespace App\Filament\Resources\WithdrawalResource\Pages;

use App\Filament\Resources\WithdrawalResource;
use App\Models\Campaign;
use App\Services\WithdrawalService;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateWithdrawal extends CreateRecord
{
    protected static string $resource = WithdrawalResource::class;

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();

        // Validate available balance
        $campaign = Campaign::with(['withdrawals' => function ($query) {
            $query->whereIn('status', ['success', 'pending']);
        }])->find($data['campaign_id']);

        if ($campaign) {
            $availableBalance = $campaign->collected_amount - $campaign->withdrawals->sum('amount');

            if ($data['amount'] > $availableBalance) {
                $this->addError(
                    'amount',
                    __('filament.resource.withdrawal.validation.amount_exceeds_balance', [
                        'available' => number_format($availableBalance, 2)
                    ])
                );
                $this->halt();
            }

            // Check if there's any pending withdrawal
            if ($campaign->withdrawals()->where('status', 'pending')->exists()) {
                Notification::make()
                    ->warning()
                    ->title(__('filament.resource.withdrawal.validation.pending_request_exists'))
                    ->persistent()
                    ->send();

                $this->halt();
            }
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        return app(WithdrawalService::class)->createRequest($data, auth()->user());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
