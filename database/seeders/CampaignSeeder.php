<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\Campaign;
use App\Models\DonationCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all associations
        $associations = Association::all();

        // Get all donation categories
        $categories = DonationCategory::all();

        // Campaign templates with Arabic data
        $campaignTemplates = [
            [
                'name_prefix' => 'بناء مسجد في ',
                'description' => 'يهدف هذا المشروع إلى بناء مسجد جديد في منطقة تفتقر إلى بيوت الله. سيتسع المسجد لأكثر من 500 مصلٍ ويشمل المشروع بناء قسم للنساء ومدرسة لتحفيظ القرآن الكريم.',
                'category_keyword' => 'بناء المساجد',
                'locations' => ['مكة', 'المدينة المنورة', 'جدة', 'الرياض', 'الدمام', 'صنعاء', 'القاهرة', 'الإسكندرية', 'بيروت', 'عمان', 'دمشق', 'غزة'],
                'donation_type' => 'share',
                'share_amount' => 1000,
                'goal_min' => 300000,
                'goal_max' => 1000000
            ],
            [
                'name_prefix' => 'حفر بئر في ',
                'description' => 'تعاني العديد من المناطق من نقص المياه الصالحة للشرب، لذا نسعى من خلال هذا المشروع إلى حفر بئر ارتوازي وتجهيزه بمضخة تعمل بالطاقة الشمسية لتوفير مياه نظيفة ومستدامة للسكان.',
                'category_keyword' => 'حفر الآبار',
                'locations' => ['السودان', 'الصومال', 'موريتانيا', 'تشاد', 'النيجر', 'مالي', 'اليمن', 'باكستان', 'أفغانستان', 'سريلانكا', 'بنغلاديش'],
                'donation_type' => 'share',
                'share_amount' => 500,
                'goal_min' => 50000,
                'goal_max' => 100000
            ],
            [
                'name_prefix' => 'كفالة أيتام في ',
                'description' => 'يهدف هذا المشروع إلى كفالة مجموعة من الأيتام وتوفير احتياجاتهم من الغذاء والكساء والتعليم والرعاية الصحية والنفسية، ليعيشوا حياة كريمة ويصبحوا أعضاء فاعلين في المجتمع.',
                'category_keyword' => 'رعاية الأيتام',
                'locations' => ['سوريا', 'اليمن', 'فلسطين', 'العراق', 'لبنان', 'الأردن', 'مصر', 'ليبيا', 'تونس', 'المغرب', 'الجزائر', 'السودان'],
                'donation_type' => 'share',
                'share_amount' => 200,
                'goal_min' => 100000,
                'goal_max' => 500000
            ],
            [
                'name_prefix' => 'إغاثة متضرري الزلزال في ',
                'description' => 'تعرضت المنطقة لزلزال مدمر خلف آلاف المتضررين الذين فقدوا منازلهم وممتلكاتهم. يهدف هذا المشروع إلى توفير مساعدات إغاثية عاجلة تشمل الخيام والبطانيات والمواد الغذائية والأدوية.',
                'category_keyword' => 'الإغاثة العاجلة',
                'locations' => ['تركيا', 'سوريا', 'المغرب', 'الجزائر', 'لبنان', 'اليمن', 'العراق', 'إيران', 'باكستان', 'أفغانستان'],
                'donation_type' => 'open',
                'share_amount' => null,
                'goal_min' => 500000,
                'goal_max' => 2000000
            ],
            [
                'name_prefix' => 'مشروع إفطار صائم في ',
                'description' => 'يهدف المشروع إلى توفير وجبات إفطار للصائمين في شهر رمضان المبارك، وخاصة الفقراء والمحتاجين والمسافرين، ليتمكنوا من أداء فريضة الصيام دون معاناة.',
                'category_keyword' => 'إفطار صائم',
                'locations' => ['مكة', 'المدينة المنورة', 'الرياض', 'جدة', 'القاهرة', 'الإسكندرية', 'دمشق', 'بيروت', 'عمان', 'غزة', 'الخرطوم', 'نواكشوط'],
                'donation_type' => 'share',
                'share_amount' => 50,
                'goal_min' => 100000,
                'goal_max' => 300000
            ],
            [
                'name_prefix' => 'مشروع كسوة العيد في ',
                'description' => 'يهدف هذا المشروع إلى توفير ملابس العيد للأطفال الفقراء والأيتام، ليفرحوا مع أقرانهم ويشعروا بالسعادة في هذه المناسبة السعيدة.',
                'category_keyword' => 'كسوة العيد',
                'locations' => ['مصر', 'سوريا', 'اليمن', 'فلسطين', 'لبنان', 'الأردن', 'العراق', 'السودان', 'الصومال', 'جيبوتي', 'موريتانيا'],
                'donation_type' => 'share',
                'share_amount' => 100,
                'goal_min' => 50000,
                'goal_max' => 200000
            ],
            [
                'name_prefix' => 'مشروع الأضاحي في ',
                'description' => 'يهدف هذا المشروع إلى توفير أضاحي العيد للفقراء والمحتاجين، ليتمكنوا من المشاركة في هذه الشعيرة الإسلامية العظيمة ويدخل السرور على قلوبهم.',
                'category_keyword' => 'الأضاحي',
                'locations' => ['مصر', 'سوريا', 'اليمن', 'فلسطين', 'لبنان', 'الأردن', 'العراق', 'السودان', 'الصومال', 'جيبوتي', 'موريتانيا'],
                'donation_type' => 'share',
                'share_amount' => 1000,
                'goal_min' => 100000,
                'goal_max' => 500000
            ],
            [
                'name_prefix' => 'مركز صحي في ',
                'description' => 'يهدف هذا المشروع إلى بناء وتجهيز مركز صحي في منطقة نائية تفتقر للخدمات الصحية. سيوفر المركز خدمات الرعاية الصحية الأولية والتطعيمات ورعاية الأمومة والطفولة للسكان.',
                'category_keyword' => 'الصحة',
                'locations' => ['السودان', 'الصومال', 'اليمن', 'سوريا', 'فلسطين', 'لبنان', 'الأردن', 'مصر', 'النيجر', 'تشاد', 'مالي', 'موريتانيا'],
                'donation_type' => 'open',
                'share_amount' => null,
                'goal_min' => 300000,
                'goal_max' => 1000000
            ],
            [
                'name_prefix' => 'مدرسة في ',
                'description' => 'يهدف هذا المشروع إلى بناء وتجهيز مدرسة في منطقة تعاني من نقص المؤسسات التعليمية. ستوفر المدرسة التعليم الأساسي للأطفال لضمان مستقبل أفضل لهم.',
                'category_keyword' => 'التعليم',
                'locations' => ['السودان', 'الصومال', 'اليمن', 'سوريا', 'فلسطين', 'لبنان', 'الأردن', 'مصر', 'النيجر', 'تشاد', 'مالي', 'موريتانيا'],
                'donation_type' => 'open',
                'share_amount' => null,
                'goal_min' => 200000,
                'goal_max' => 800000
            ],
            [
                'name_prefix' => 'برنامج تمكين الأسر المحتاجة في ',
                'description' => 'يهدف هذا البرنامج إلى تأهيل الأسر المحتاجة من خلال تدريبهم على حرف ومهارات تمكنهم من إقامة مشاريع صغيرة تدر عليهم دخلاً يغنيهم عن السؤال.',
                'category_keyword' => 'كفالة الأسر المحتاجة',
                'locations' => ['مصر', 'السعودية', 'الإمارات', 'سوريا', 'اليمن', 'الأردن', 'فلسطين', 'لبنان', 'العراق', 'المغرب', 'تونس', 'الجزائر'],
                'donation_type' => 'open',
                'share_amount' => null,
                'goal_min' => 200000,
                'goal_max' => 500000
            ],
        ];

        // Start and end dates for campaigns
        $startDates = [
            Carbon::now()->subMonth(6),
            Carbon::now()->subMonth(3),
            Carbon::now()->subMonth(1),
            Carbon::now(),
            Carbon::now()->addMonth(1),
        ];

        $endDates = [
            Carbon::now()->addMonth(6),
            Carbon::now()->addMonth(12),
            Carbon::now()->addMonth(18),
        ];

        $createdCampaigns = 0;

        // Create campaigns
        foreach ($associations as $association) {
            // Get managers of this association
            $managers = $association->user;
            if (!$managers) {
                $managers = User::where('type', 'association_manager')->inRandomOrder()->first();
            }

            // Create 5-10 campaigns per association
            $campaignsCount = rand(5, 10);

            for ($i = 0; $i < $campaignsCount; $i++) {
                // Select random campaign template
                $template = $campaignTemplates[array_rand($campaignTemplates)];

                // Find matching category
                $category = $categories->where('name', 'like', '%' . $template['category_keyword'] . '%')->first();
                if (!$category) {
                    $category = $categories->random();
                }

                // Select random location
                $location = $template['locations'][array_rand($template['locations'])];

                // Generate random goal amount
                $goalAmount = rand($template['goal_min'], $template['goal_max']);

                // Select random start and end dates
                $startDate = $startDates[array_rand($startDates)];
                $endDate = $endDates[array_rand($endDates)];

                // Make sure end date is after start date
                if ($endDate <= $startDate) {
                    $endDate = $startDate->copy()->addMonths(6);
                }

                // Create campaign
                $campaign = Campaign::create([
                    'name' => $template['name_prefix'] . $location,
                    'description' => $template['description'],
                    'address' => $location,
                    'status' => rand(0, 5) > 0 ? 'active' : 'inactive', // 5/6 chance to be active
                    'goal_amount' => $goalAmount,
                    'collected_amount' => $startDate->isPast() ? rand(0, $goalAmount) : 0, // Some collection if campaign already started
                    'donation_type' => $template['donation_type'],
                    'share_amount' => $template['donation_type'] === 'share' ? $template['share_amount'] : null,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'association_id' => $association->id,
                    'donation_category_id' => $category->id,
                    'created_by' => $managers->id,
                ]);

                $createdCampaigns++;

                if ($createdCampaigns % 10 === 0) {
                    $this->command->info("Created {$createdCampaigns} campaigns...");
                }
            }
        }

        $this->command->info("Total campaigns created: {$createdCampaigns}");
    }
}
