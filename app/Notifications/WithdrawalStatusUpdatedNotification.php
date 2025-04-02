<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawalStatusUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Withdrawal $withdrawal
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $title = match($this->withdrawal->status) {
            'success' => 'Withdrawal Request Approved',
            'failed' => 'Withdrawal Request Rejected',
            default => 'Withdrawal Status Updated',
        };

        $body = "Withdrawal request of {$this->withdrawal->amount} for {$this->withdrawal->association->name}";
        if ($this->withdrawal->campaign) {
            $body .= " - {$this->withdrawal->campaign->name}";
        }
        $body .= " has been " . ($this->withdrawal->status === 'success' ? 'approved' : 'rejected');

        if ($this->withdrawal->note && $this->withdrawal->status === 'failed') {
            $body .= "\nReason: {$this->withdrawal->note}";
        }

        return [
            'title' => $title,
            'body' => $body,
            'actions' => [
                [
                    'label' => 'View Details',
                    'url' => url('/portal/withdrawals'), // Use URL helper instead of route helper
                    'icon' => 'heroicon-o-eye',
                ],
            ],
            'withdrawal_id' => $this->withdrawal->id,
            'amount' => $this->withdrawal->amount,
            'status' => $this->withdrawal->status,
            'association_name' => $this->withdrawal->association->name,
            'campaign_name' => $this->withdrawal->campaign?->name,
            'processed_by' => $this->withdrawal->processor?->name,
            'note' => $this->withdrawal->note,
            'icon' => 'heroicon-o-banknotes',
            'color' => match($this->withdrawal->status) {
                'success' => 'success',
                'failed' => 'danger',
                default => 'warning',
            },
        ];
    }
}
