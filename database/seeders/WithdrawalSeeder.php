<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get campaigns with money collected
        $campaigns = Campaign::where('status', 'active')
            ->where('collected_amount', '>', 0)
            ->get();

        // Get admin users for processing withdrawals
        $admins = User::where('type', 'admin')->get();

        // Arabic rejection notes
        $rejectionNotes = [
            'نقص في المستندات المطلوبة للتحويل',
            'معلومات الحساب البنكي غير صحيحة أو غير مكتملة',
            'المبلغ المطلوب يتجاوز المبلغ المتاح للسحب',
            'تم تجميد الحساب مؤقتًا لأسباب أمنية',
            'يجب تقديم تقرير عن استخدام الأموال السابقة قبل طلب سحب جديد',
            'لم يتم استيفاء الشروط المطلوبة للسحب',
            'هناك طلب سحب آخر قيد المعالجة حاليًا'
        ];

        $totalWithdrawals = 0;

        foreach ($campaigns as $campaign) {
            // Determine if we should create withdrawals for this campaign (70% chance)
            if (rand(1, 10) <= 7) {
                // Get campaign creator or a random manager
                $creator = User::find($campaign->created_by);
                if (!$creator || $creator->type !== 'association_manager') {
                    $creator = User::where('type', 'association_manager')->inRandomOrder()->first();
                }

                // Determine how many withdrawals to create (1-3)
                $withdrawalsCount = rand(1, 3);

                // Track total withdrawn amount
                $totalWithdrawn = 0;

                for ($i = 0; $i < $withdrawalsCount; $i++) {
                    // Calculate maximum possible withdrawal (not exceeding remaining amount)
                    $maxAvailable = $campaign->collected_amount - $totalWithdrawn;

                    if ($maxAvailable <= 0) {
                        break;
                    }

                    // Determine amount (between 30-90% of available funds)
                    $percentage = rand(30, 90) / 100;
                    $amount = round($maxAvailable * $percentage, 2);

                    // Ensure minimum amount of 1000
                    if ($amount < 1000) {
                        break;
                    }

                    // Determine request date
                    $requestedAt = Carbon::createFromTimestamp(
                        rand(max($campaign->start_date->timestamp, Carbon::now()->subMonths(3)->timestamp),
                            Carbon::now()->timestamp)
                    );

                    // Determine status (70% success, 20% pending, 10% failed)
                    $statusRoll = rand(1, 10);
                    $status = $statusRoll <= 7 ? 'success' : ($statusRoll <= 9 ? 'pending' : 'failed');

                    // Determine processed date and processor
                    $processedAt = null;
                    $processorId = null;

                    if ($status !== 'pending') {
                        $processedAt = $requestedAt->copy()->addDays(rand(1, 5));
                        $processorId = $admins->random()->id;
                    }

                    // Create withdrawal
                    $withdrawal = Withdrawal::create([
                        'association_id' => $campaign->association_id,
                        'campaign_id' => $campaign->id,
                        'amount' => $amount,
                        'note' => $status === 'failed' ? $rejectionNotes[array_rand($rejectionNotes)] : null,
                        'requested_at' => $requestedAt,
                        'processed_at' => $processedAt,
                        'status' => $status,
                        'requester_id' => $creator->id,
                        'processor_id' => $processorId,
                        'created_at' => $requestedAt,
                        'updated_at' => $processedAt ?? $requestedAt,
                    ]);

                    if ($status === 'success' || $status === 'pending') {
                        $totalWithdrawn += $amount;
                    }

                    $totalWithdrawals++;

                    if ($totalWithdrawals % 25 === 0) {
                        $this->command->info("Created {$totalWithdrawals} withdrawals...");
                    }
                }
            }
        }

        $this->command->info("Total withdrawals created: {$totalWithdrawals}");
    }
}
