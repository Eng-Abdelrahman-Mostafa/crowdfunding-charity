<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get association managers
        $managers = User::where('type', 'association_manager')->get();

        // Create realistic Arabic association names
        $associations = [
            [
                'name' => 'جمعية البر الخيرية',
                'description' => 'تعتبر جمعية البر الخيرية من أقدم الجمعيات الخيرية في المملكة، تأسست عام 1374هـ، وتقدم خدمات متعددة للأسر المحتاجة والأيتام والأرامل.',
                'website' => 'https://albirr.org',
                'city' => 'الرياض',
                'country' => 'المملكة العربية السعودية'
            ],
            [
                'name' => 'مؤسسة مصر الخير',
                'description' => 'مؤسسة مصر الخير هي مؤسسة تنموية غير هادفة للربح تسعى لتنمية الإنسان المصري في المجالات الأكثر احتياجاً.',
                'website' => 'https://misrelkheir.org',
                'city' => 'القاهرة',
                'country' => 'مصر'
            ],
            [
                'name' => 'جمعية قطر الخيرية',
                'description' => 'جمعية خيرية غير حكومية تأسست في عام 1992م، تعمل في مجالات التنمية وتمكين المجتمعات الضعيفة داخل وخارج قطر.',
                'website' => 'https://qcharity.org',
                'city' => 'الدوحة',
                'country' => 'قطر'
            ],
            [
                'name' => 'جمعية الإحسان الخيرية',
                'description' => 'جمعية تهدف إلى تقديم المساعدات للأسر المتعففة وتوفير الرعاية الصحية للمحتاجين والتعليم للطلاب المعسرين.',
                'website' => 'https://ihsaan.org',
                'city' => 'جدة',
                'country' => 'المملكة العربية السعودية'
            ],
            [
                'name' => 'جمعية الهلال الأحمر',
                'description' => 'منظمة إنسانية تطوعية تعمل في مجال الإغاثة وتقديم المساعدات الإنسانية وقت الكوارث والأزمات.',
                'website' => 'https://redcrescent.org.sa',
                'city' => 'الرياض',
                'country' => 'المملكة العربية السعودية'
            ],
            [
                'name' => 'مؤسسة العطاء الخيرية',
                'description' => 'مؤسسة خيرية تهتم برعاية الأيتام وتقديم المساعدات للأسر المحتاجة وبناء المشاريع التنموية.',
                'website' => 'https://alataa.org',
                'city' => 'أبو ظبي',
                'country' => 'الإمارات العربية المتحدة'
            ],
            [
                'name' => 'جمعية رعاية الأيتام',
                'description' => 'جمعية متخصصة في رعاية الأيتام وتوفير الحياة الكريمة لهم من خلال برامج التعليم والصحة والإسكان.',
                'website' => 'https://orphans-care.org',
                'city' => 'الدمام',
                'country' => 'المملكة العربية السعودية'
            ],
            [
                'name' => 'جمعية الخير المستدام',
                'description' => 'جمعية تركز على المشاريع التنموية المستدامة مثل بناء المساجد وحفر الآبار والمشاريع الصغيرة المدرة للدخل.',
                'website' => 'https://sustainablegood.org',
                'city' => 'عمان',
                'country' => 'الأردن'
            ],
            [
                'name' => 'جمعية الرحمة العالمية',
                'description' => 'جمعية خيرية عالمية تهتم بالإغاثة الإنسانية وتنفيذ المشاريع التنموية في الدول الفقيرة والمتضررة من الكوارث.',
                'website' => 'https://mercy-world.org',
                'city' => 'الكويت',
                'country' => 'الكويت'
            ],
            [
                'name' => 'جمعية التكافل الاجتماعي',
                'description' => 'جمعية تعمل على تحقيق التكافل الاجتماعي من خلال مساعدة الأسر الفقيرة والمحتاجة وتأهيلهم للاعتماد على أنفسهم.',
                'website' => 'https://takaful.org',
                'city' => 'المنامة',
                'country' => 'البحرين'
            ],
        ];

        foreach ($associations as $index => $associationData) {
            // Create association with a manager
            $manager = $managers[$index % count($managers)];

            $association = Association::create([
                'name' => $associationData['name'],
                'description' => $associationData['description'],
                'website' => $associationData['website'],
                'email' => 'info@' . explode('//', $associationData['website'])[1],
                'phone' => '05' . rand(10000000, 99999999),
                'address' => 'شارع ' . rand(1, 100) . '، حي ' . ['الروضة', 'النزهة', 'المروج', 'العليا', 'النسيم'][rand(0, 4)],
                'city' => $associationData['city'],
                'state' => $associationData['city'],
                'zip' => rand(10000, 99999),
                'country' => $associationData['country'],
                'status' => 'active',
                'created_by' => $manager->id,
            ]);

            // Link manager to association
            $manager->associations()->attach($association->id);

            $this->command->info("Created association: {$association->name}");
        }

        $this->command->info('Associations seeded successfully!');
    }
}
