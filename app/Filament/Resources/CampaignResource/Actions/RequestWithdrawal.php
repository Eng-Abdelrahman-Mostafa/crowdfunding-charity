<?php

namespace App\Filament\Resources\CampaignResource\Actions;

use App\Models\Campaign;
use App\Models\Withdrawal;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class RequestWithdrawal extends Action
{
    public static function getDefaultName(): ?string
    {
        return __('filament.resource.campaign.request-withdrawal');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-banknotes')
            ->modalHeading(fn () => __('filament.resource.campaign.request_withdrawal'))
            ->form([
                Grid::make()
                    ->schema([
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label(__('filament.resource.withdrawal.amount'))
                            ->hint(fn (Model $record) => __('filament.resource.withdrawal.available_balance', [
                                'amount' => number_format($record->getAvailableBalance(), 2)
                            ]))
                            ->helperText(__('filament.resource.withdrawal.amount_helper')),

                        Textarea::make('note')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->label(__('filament.resource.withdrawal.note')),
                    ]),
            ])
            ->action(function (Campaign $record, array $data): void {
                $availableBalance = $record->getAvailableBalance();

                if ($data['amount'] > $availableBalance) {
                    $this->addError(
                        'amount',
                        __('filament.resource.withdrawal.validation.amount_exceeds_balance', [
                            'available' => $availableBalance
                        ])
                    );
                    $this->halt();
                }

                $withdrawal = Withdrawal::create([
                    'association_id' => $record->association_id,
                    'campaign_id' => $record->id,
                    'amount' => $data['amount'],
                    'note' => $data['note'],
                    'status' => 'pending',
                    'requester_id' => auth()->id(),
                    'requested_at' => now(),
                ]);

                // Fire notification event
                event(new \App\Events\WithdrawalRequested($withdrawal));

                $this->success();
            })
            ->successNotificationTitle(__('filament.resource.withdrawal.requested'))
            ->visible(fn (Model $record) =>
                $record->status === 'active' &&
                $record->getAvailableBalance() > 0 &&
                auth()->user()->can('create', Withdrawal::class)
            );
    }
}
