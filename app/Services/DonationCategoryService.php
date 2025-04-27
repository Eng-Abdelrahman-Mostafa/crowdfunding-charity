<?php

namespace App\Services;

use App\Models\DonationCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DonationCategoryService
{
    /**
     * Cache key for donation categories
     */
    const CACHE_KEY = 'donation_categories';

    /**
     * Cache TTL in seconds (1 day)
     */
    const CACHE_TTL = 86400;

    /**
     * Get all donation categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL,
            function () {
                return DonationCategory::inRandomOrder()->limit(8)->get();
            }
        );
    }

    /**
     * Clear donation categories cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
