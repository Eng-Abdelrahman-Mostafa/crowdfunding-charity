<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalRequestedNotification;
use App\Notifications\WithdrawalStatusUpdatedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class WithdrawalService
{
    public function createRequest(array $data, User $requester): Withdrawal
    {
        Log::info('Creating withdrawal request', ['data' => $data]);

        return DB::transaction(function () use ($data, $requester) {
            // Create withdrawal
            $withdrawal = Withdrawal::create([
                'association_id' => $data['association_id'],
                'campaign_id' => $data['campaign_id'] ?? null,
                'amount' => $data['amount'],
                'note' => $data['note'] ?? null,
                'status' => 'pending',
                'requester_id' => $requester->id,
                'requested_at' => now(),
            ]);

            Log::info('Withdrawal created', ['withdrawal_id' => $withdrawal->id]);

            // Get all admin users
            $admins = User::query()
                ->where('type', 'admin')
                ->get();

            Log::info('Found admins', ['count' => $admins->count()]);

            // Send notifications to all admins
            if ($admins->isNotEmpty()) {
                try {
                    Notification::send($admins, new WithdrawalRequestedNotification($withdrawal));
                    Log::info('Notifications sent successfully');
                } catch (\Exception $e) {
                    Log::error('Failed to send notifications', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                Log::warning('No admins found to notify');
            }

            return $withdrawal;
        });
    }

    public function approveRequest(Withdrawal $withdrawal, User $processor): void
    {
        Log::info('Approving withdrawal request', ['withdrawal_id' => $withdrawal->id]);

        DB::transaction(function () use ($withdrawal, $processor) {
            $withdrawal->update([
                'status' => 'success',
                'processed_at' => now(),
                'processor_id' => $processor->id,
            ]);

            try {
                $withdrawal->requester->notify(new WithdrawalStatusUpdatedNotification($withdrawal));
                Log::info('Approval notification sent');
            } catch (\Exception $e) {
                Log::error('Failed to send approval notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        });
    }

    public function rejectRequest(Withdrawal $withdrawal, User $processor, string $rejectionNote): void
    {
        Log::info('Rejecting withdrawal request', ['withdrawal_id' => $withdrawal->id]);

        DB::transaction(function () use ($withdrawal, $processor, $rejectionNote) {
            $withdrawal->update([
                'status' => 'failed',
                'processed_at' => now(),
                'processor_id' => $processor->id,
                'note' => $rejectionNote,
            ]);

            try {
                $withdrawal->requester->notify(new WithdrawalStatusUpdatedNotification($withdrawal));
                Log::info('Rejection notification sent');
            } catch (\Exception $e) {
                Log::error('Failed to send rejection notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        });
    }

    public function calculateAvailableBalance(Campaign $campaign): float
    {
        $withdrawalsSum = $campaign->withdrawals()
            ->whereIn('status', ['success', 'pending'])
            ->sum('amount');

        return $campaign->collected_amount - $withdrawalsSum;
    }
}
