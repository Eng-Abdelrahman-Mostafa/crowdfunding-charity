<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            DonationCategorySeeder::class,
            AssociationSeeder::class,
            CampaignSeeder::class,
            DonationSeeder::class,
            ExpenditureSeeder::class,
            WithdrawalSeeder::class,
        ]);
    }
}
