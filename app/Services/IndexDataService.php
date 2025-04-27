<?php

namespace App\Services;

use App\Models\Association;
use App\Models\Campaign;
use App\Models\DonationCategory;
use Illuminate\Support\Facades\Cache;

class IndexDataService
{
    /**
     * Get all index data for the home page
     *
     * @return array
     */
    public function getIndexData(): array
    {
        return Cache::remember('index_data', now()->addHours(24), function () {
            return [
                'donation_categories' => $this->getDonationCategories(),
                'donation_categories_count' => $this->getDonationCategoriesCount(),
                'associations_count' => $this->getAssociationsCount(),
                'campaigns_count' => $this->getCampaignsCount(),
                'associations' => $this->getAssociations(),
            ];
        });
    }

    /**
     * Get all donation categories
     *
     * @return array
     */
    private function getDonationCategories(): array
    {
        return DonationCategory::select('name','id')->get()->toArray();
    }

    /**
     * Get donation categories count
     *
     * @return int
     */
    private function getDonationCategoriesCount(): int
    {
        return DonationCategory::count();
    }

    /**
     * Get associations count
     *
     * @return int
     */
    private function getAssociationsCount(): int
    {
        return Association::count();
    }

    /**
     * Get campaigns count
     *
     * @return int
     */
    private function getCampaignsCount(): int
    {
        return Campaign::count();
    }

    /**
     * Get associations with logo and website
     *
     * @return array
     */
    private function getAssociations(): array
    {
        return Association::select('name', 'website')
            ->with('media')
            ->get()
            ->map(function ($association) {
                return [
                    'name' => $association->name,
                    'website' => $association->website,
                    'logo' => $association->logo,
                ];
            })
            ->toArray();
    }

    /**
     * Clear the index data cache
     *
     * @return bool
     */
    public function clearCache(): bool
    {
        return Cache::forget('index_data');
    }
}
