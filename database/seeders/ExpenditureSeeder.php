<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Expenditure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get campaigns that have been running for at least a month
        $campaigns = Campaign::where('status', 'active')
            ->where('start_date', '<=', now()->subMonth())
            ->where('collected_amount', '>', 0)
            ->get();

        // Expenditure types and descriptions in Arabic
        $expenditureTypes = [
            [
                'name_prefix' => 'تكاليف مواد بناء - ',
                'description' => 'تكاليف شراء مواد البناء اللازمة للمشروع مثل الإسمنت والحديد والطوب والرمل.'
            ],
            [
                'name_prefix' => 'أجور عمال - ',
                'description' => 'تكاليف أجور العمال والفنيين المشاركين في تنفيذ المشروع.'
            ],
            [
                'name_prefix' => 'معدات ومعدات - ',
                'description' => 'تكاليف شراء أو استئجار المعدات اللازمة لتنفيذ المشروع.'
            ],
            [
                'name_prefix' => 'تكاليف نقل - ',
                'description' => 'تكاليف نقل المواد والمعدات إلى موقع المشروع.'
            ],
            [
                'name_prefix' => 'تكاليف استشارية - ',
                'description' => 'تكاليف الاستشارات الهندسية والفنية اللازمة لتنفيذ المشروع.'
            ],
            [
                'name_prefix' => 'مصاريف إدارية - ',
                'description' => 'المصاريف الإدارية المرتبطة بتنفيذ المشروع مثل الرواتب والإيجارات والأدوات المكتبية.'
            ],
            [
                'name_prefix' => 'شراء مستلزمات - ',
                'description' => 'تكاليف شراء المستلزمات اللازمة للمشروع مثل الأدوية والمواد الغذائية والملابس.'
            ],
            [
                'name_prefix' => 'مصاريف تدريب - ',
                'description' => 'تكاليف تدريب الكوادر المشاركة في تنفيذ المشروع.'
            ],
            [
                'name_prefix' => 'مصاريف تسويق - ',
                'description' => 'تكاليف الدعاية والتسويق للمشروع لجذب المتبرعين والمستفيدين.'
            ],
            [
                'name_prefix' => 'تكاليف صيانة - ',
                'description' => 'تكاليف صيانة المرافق والمعدات المستخدمة في المشروع.'
            ]
        ];

        $totalExpenditures = 0;

        foreach ($campaigns as $campaign) {
            // Determine how many expenditures to create (1-10)
            $expendituresCount = rand(1, 10);

            // Get campaign creator or a random manager
            $creator = User::find($campaign->created_by);
            if (!$creator) {
                $creator = User::where('type', 'association_manager')->inRandomOrder()->first();
            }

            // Calculate maximum possible expenditure (not exceeding collected amount)
            $maxTotalExpenditure = $campaign->collected_amount * 0.8; // Use up to 80% of collected amount
            $remainingAmount = $maxTotalExpenditure;

            for ($i = 0; $i < $expendituresCount && $remainingAmount > 0; $i++) {
                // Select random expenditure type
                $expenditureType = $expenditureTypes[array_rand($expenditureTypes)];

                // Determine amount (not exceeding remaining amount)
                $amount = min(rand(1000, 50000), $remainingAmount);
                $remainingAmount -= $amount;

                // Determine date between campaign start and now
                $date = Carbon::createFromTimestamp(rand($campaign->start_date->timestamp, now()->timestamp));

                // Create expenditure
                Expenditure::create([
                    'name' => $expenditureType['name_prefix'] . $campaign->name,
                    'description' => $expenditureType['description'],
                    'amount' => $amount,
                    'date' => $date,
                    'campaign_id' => $campaign->id,
                    'created_by' => $creator->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $totalExpenditures++;

                if ($totalExpenditures % 50 === 0) {
                    $this->command->info("Created {$totalExpenditures} expenditures...");
                }
            }
        }

        $this->command->info("Total expenditures created: {$totalExpenditures}");
    }
}
