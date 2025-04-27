<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\IndexDataService;
use Illuminate\Support\Facades\App;

class CampaignObserver
{
    /**
     * Handle the Campaign "created" event.
     */
    public function created(Campaign $campaign): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Campaign "updated" event.
     */
    public function updated(Campaign $campaign): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }
    public function saved(Campaign $campaign): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Campaign "deleted" event.
     */
    public function deleted(Campaign $campaign): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Campaign "restored" event.
     */
    public function restored(Campaign $campaign): void
    {
        $this->clearCache();
        $this->clearApiCache();
    }

    /**
     * Handle the Campaign "force deleted" event.
     */
    public function forceDeleted(Campaign $campaign): void
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
        $campaignService = App::make(CampaignService::class);
        $campaignService->clearCache();
    }
}
