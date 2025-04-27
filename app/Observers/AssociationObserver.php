<?php

namespace App\Observers;

use App\Models\Association;
use App\Services\CampaignService;
use App\Services\IndexDataService;
use Illuminate\Support\Facades\App;

class AssociationObserver
{
    /**
     * Handle the Association "created" event.
     */
    public function created(Association $association): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Association "updated" event.
     */
    public function updated(Association $association): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }
    public function saved(Association $association): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Association "deleted" event.
     */
    public function deleted(Association $association): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Association "restored" event.
     */
    public function restored(Association $association): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Association "force deleted" event.
     */
    public function forceDeleted(Association $association): void
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
        // Clear campaigns cache since it includes association data
        $campaignService = App::make(CampaignService::class);
        $campaignService->clearCache();
    }
}
