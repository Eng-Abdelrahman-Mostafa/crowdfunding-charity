<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Arabic first names
        $arabicFirstNames = [
            'محمد', 'أحمد', 'عبدالله', 'علي', 'عمر', 'خالد', 'سعيد', 'إبراهيم', 'يوسف', 'حسن',
            'فاطمة', 'عائشة', 'مريم', 'زينب', 'نور', 'سارة', 'هدى', 'رنا', 'لينا', 'سلمى',
            'ياسر', 'عادل', 'ماجد', 'نبيل', 'طارق', 'بلال', 'زياد', 'هاني', 'وليد', 'رامي'
        ];

        // Arabic last names
        $arabicLastNames = [
            'العربي', 'المصري', 'السعودي', 'الأحمد', 'المحمد', 'الخالد', 'السيد', 'الحسن', 'العمري',
            'الرشيدي', 'الهاشمي', 'القرشي', 'الزهراني', 'الشهري', 'العتيبي', 'القحطاني', 'الدوسري',
            'الحربي', 'المالكي', 'الزهراوي', 'البلوي', 'الجهني', 'الغامدي', 'الشمري', 'المطيري'
        ];

        // Get roles
        $adminRole = Role::where('name', 'super-admin')->first();
        $managerRole = Role::where('name', 'association-manager')->first();
        $donorRole = Role::where('name', 'donor')->first();

        // Create association managers (10)
        $this->command->info('Creating association managers...');
        for ($i = 1; $i <= 10; $i++) {
            $firstName = $arabicFirstNames[array_rand($arabicFirstNames)];
            $lastName = $arabicLastNames[array_rand($arabicLastNames)];
            $fullName = $firstName . ' ' . $lastName;

            $manager = User::create([
                'name' => $fullName,
                'email' => 'manager' . $i . '@example.com',
                'phone' => '05' . rand(10000000, 99999999),
                'password' => Hash::make('password'),
                'type' => 'association_manager',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $manager->assignRole($managerRole);

            $this->command->info("Created association manager: {$fullName}");
        }

        // Create donors (50)
        $this->command->info('Creating donors...');
        for ($i = 1; $i <= 50; $i++) {
            $firstName = $arabicFirstNames[array_rand($arabicFirstNames)];
            $lastName = $arabicLastNames[array_rand($arabicLastNames)];
            $fullName = $firstName . ' ' . $lastName;

            $donor = User::create([
                'name' => $fullName,
                'email' => 'donor' . $i . '@example.com',
                'phone' => '05' . rand(10000000, 99999999),
                'password' => Hash::make('password'),
                'type' => 'donor',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $donor->assignRole($donorRole);
        }

        $this->command->info('Users seeded successfully!');
    }
}
