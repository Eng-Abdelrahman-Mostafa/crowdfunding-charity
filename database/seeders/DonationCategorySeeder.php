<?php

namespace Database\Seeders;

use App\Models\DonationCategory;
use Illuminate\Database\Seeder;

class DonationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arabicCategories = [
            'الإغاثة الإنسانية',
            'رعاية الأيتام',
            'بناء المساجد',
            'حفر الآبار',
            'كفالة الأسر المحتاجة',
            'التعليم',
            'الصحة',
            'ذوي الاحتياجات الخاصة',
            'الإغاثة العاجلة',
            'إفطار صائم',
            'كسوة العيد',
            'الأضاحي',
            'الزكاة',
            'الصدقة الجارية',
            'مشاريع التنمية'
        ];

        foreach ($arabicCategories as $category) {
            DonationCategory::create([
                'name' => $category
            ]);
        }

        $this->command->info('Donation categories seeded successfully!');
    }
}
