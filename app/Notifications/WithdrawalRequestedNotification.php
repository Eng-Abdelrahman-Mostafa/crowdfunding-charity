<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WithdrawalRequestedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Withdrawal $withdrawal
    ) {
        Log::info('Creating WithdrawalRequestedNotification', ['withdrawal_id' => $withdrawal->id]);
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        try {
            return [
                'title' => 'New Withdrawal Request',
                'body' => "A new withdrawal request has been created for amount: {$this->withdrawal->amount}",
                'withdrawal_id' => $this->withdrawal->id,
                'amount' => $this->withdrawal->amount
            ];
        } catch (\Exception $e) {
            Log::error('Error in WithdrawalRequestedNotification toArray', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }
}
