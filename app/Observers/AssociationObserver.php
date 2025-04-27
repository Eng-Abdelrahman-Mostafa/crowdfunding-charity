<?php

namespace App\Observers;

use App\Models\Association;
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
    }

    /**
     * Handle the Association "updated" event.
     */
    public function updated(Association $association): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Association "deleted" event.
     */
    public function deleted(Association $association): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Association "restored" event.
     */
    public function restored(Association $association): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Association "force deleted" event.
     */
    public function forceDeleted(Association $association): void
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
