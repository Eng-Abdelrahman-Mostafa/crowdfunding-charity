<?php

namespace App\Observers;

use App\Models\Campaign;
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
    }

    /**
     * Handle the Campaign "updated" event.
     */
    public function updated(Campaign $campaign): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Campaign "deleted" event.
     */
    public function deleted(Campaign $campaign): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Campaign "restored" event.
     */
    public function restored(Campaign $campaign): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Campaign "force deleted" event.
     */
    public function forceDeleted(Campaign $campaign): void
    {
        $this->clearCache();
    }

    /**
     * Clear the index data cache
     */
    private function clearCache(): void
    {
        $indexDataService = App::make(IndexDataService::class);
        $indexDataService->clearCache();
    }
}
