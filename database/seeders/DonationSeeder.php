<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active campaigns
        $campaigns = Campaign::where('status', 'active')
            ->where('start_date', '<=', now())
            ->get();

        // Get all donors
        $donors = User::where('type', 'donor')->get();

        // Get managers for offline donations
        $managers = User::where('type', 'association_manager')->get();

        // Currency options
        $currencies = ['EGP', 'USD', 'SAR', 'AED', 'KWD'];

        // Payment methods
        $paymentMethods = ['online', 'offline'];

        // Online payment options
        $onlinePaymentOptions = ['PayPal', 'Stripe', 'Fawry', 'Paytabs', 'Tap', 'STC Pay', 'Apple Pay'];

        // Offline payment options
        $offlinePaymentOptions = ['Bank Transfer', 'Cash', 'Cheque'];

        $this->command->info('Creating donations for active campaigns...');

        $totalDonations = 0;

        foreach ($campaigns as $campaign) {
            // Generate between 10-50 donations per campaign
            $donationsCount = rand(10, 50);

            for ($i = 0; $i < $donationsCount; $i++) {
                // Select random donor
                $donor = $donors->random();

                // Determine payment method
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

                // Determine amount based on donation type
                if ($campaign->donation_type === 'share') {
                    // For share campaigns, donation amount is multiple of share amount
                    $amount = $campaign->share_amount * rand(1, 10);
                } else {
                    // For open campaigns, random amount
                    $amount = rand(50, 5000);
                }

                // Determine creation date between campaign start and now (or campaign end if ended)
                $endPoint = $campaign->end_date->isPast() ? $campaign->end_date : now();
                $createdAt = Carbon::createFromTimestamp(rand($campaign->start_date->timestamp, $endPoint->timestamp));

                // Create donation
                $donation = Donation::create([
                    'donor_id' => $donor->id,
                    'campaign_id' => $campaign->id,
                    'created_by' => $paymentMethod === 'offline' ? $managers->random()->id : null,
                    'amount' => $amount,
                    'currency' => $currencies[array_rand($currencies)],
                    'payment_status' => rand(1, 10) <= 8 ? 'success' : (rand(0, 1) ? 'pending' : 'failed'), // 80% success, 10% pending, 10% failed
                    'payment_method' => $paymentMethod,
                    'payment_with' => $paymentMethod === 'online'
                        ? $onlinePaymentOptions[array_rand($onlinePaymentOptions)]
                        : $offlinePaymentOptions[array_rand($offlinePaymentOptions)],
                    'invoice_id' => 'INV-' . strtoupper(substr(md5(rand()), 0, 10)),
                    'invoice_key' => strtoupper(substr(md5(rand()), 0, 16)),
                    'invoice_url' => 'https://example.com/invoices/' . strtoupper(substr(md5(rand()), 0, 10)),
                    'paid_at' => rand(1, 10) <= 8 ? $createdAt : null, // Paid at same time for most donations
                    'due_date' => $createdAt->copy()->addDays(7), // Due date 1 week after creation
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // If donation is successful, update campaign collected amount
                if ($donation->payment_status === 'success') {
                    $campaign->increment('collected_amount', $amount);
                }

                $totalDonations++;

                if ($totalDonations % 100 === 0) {
                    $this->command->info("Created {$totalDonations} donations...");
                }
            }
        }

        $this->command->info("Total donations created: {$totalDonations}");
    }
}
