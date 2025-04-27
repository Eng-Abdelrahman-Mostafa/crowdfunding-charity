<?php

namespace App\Observers;

use App\Models\DonationCategory;
use App\Services\DonationCategoryService;
use App\Services\IndexDataService;
use Illuminate\Support\Facades\App;

class DonationCategoryObserver
{
    /**
     * Handle the DonationCategory "created" event.
     */
    public function created(DonationCategory $donationCategory): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the DonationCategory "updated" event.
     */
    public function updated(DonationCategory $donationCategory): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }
    public function saved(DonationCategory $donationCategory): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }
    /**
     * Handle the DonationCategory "deleted" event.
     */
    public function deleted(DonationCategory $donationCategory): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the DonationCategory "restored" event.
     */
    public function restored(DonationCategory $donationCategory): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the DonationCategory "force deleted" event.
     */
    public function forceDeleted(DonationCategory $donationCategory): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Clear the index data cache
     */
    private function clearCache(): void
    {
        $indexDataService = App::make(IndexDataService::class);
        $indexDataService->clearCache();
    }

    /**
     * Clear the API cache
     */
    private function clearApiCache(): void
    {
        $donationCategoryService = App::make(DonationCategoryService::class);
        $donationCategoryService->clearCache();
    }
}
