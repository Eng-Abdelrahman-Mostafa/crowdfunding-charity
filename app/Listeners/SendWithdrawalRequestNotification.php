<?php

namespace App\Listeners;

use App\Events\WithdrawalRequested;
use App\Models\User;
use App\Notifications\WithdrawalRequestedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendWithdrawalRequestNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(WithdrawalRequested $event): void
    {
        // Get all admin users
        $admins = User::role('super-admin')->get();

        // Send notification
        Notification::send(
            $admins,
            new WithdrawalRequestedNotification($event->withdrawal)
        );
    }
}
