<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CampaignService
{
    /**
     * Cache key prefix for campaigns
     */
    const CACHE_KEY_PREFIX = 'campaigns_';

    /**
     * Cache TTL in seconds (1 hour)
     */
    const CACHE_TTL = 3600;

    /**
     * Get active campaigns with filters
     *
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getActiveCampaigns(array $queryParams = [], int $perPage = 15): LengthAwarePaginator
    {
        // Create a cache key based on the query parameters
        $cacheKey = $this->generateCacheKey($queryParams, $perPage);

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            function () use ($queryParams, $perPage) {
                return $this->fetchCampaignsFromDatabase($queryParams, $perPage);
            }
        );
    }

    /**
     * Get a single campaign by ID with all related data
     *
     * @param int $id
     * @return Campaign
     * @throws ModelNotFoundException
     */
    public function getCampaignById(int $id): Campaign
    {
        $campaign = Campaign::with([
            'association',
            'donationCategory',
            'user',
            'donations' => function($query) {
                $query->with('donor')
                      ->where('payment_status', 'success')
                      ->latest()
                      ->take(5);
            },
            'expenditures' => function($query) {
                $query->latest('date');
            }
        ])->findOrFail($id);

        return $campaign;
    }

    /**
     * Clear campaigns cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        // Get all cache keys with our prefix
        $cacheKeys = Cache::getStore()->many(Cache::get('campaign_cache_keys', []));

        // Forget each key
        foreach ($cacheKeys as $key => $value) {
            if (strpos($key, self::CACHE_KEY_PREFIX) === 0) {
                Cache::forget($key);
            }
        }

        // Clear the cache keys tracker
        Cache::forget('campaign_cache_keys');
    }

    /**
     * Generate a cache key based on the query parameters
     *
     * @param array $queryParams
     * @param int $perPage
     * @return string
     */
    private function generateCacheKey(array $queryParams, int $perPage): string
    {
        $queryString = http_build_query($queryParams);
        $cacheKey = self::CACHE_KEY_PREFIX . md5($queryString . '_' . $perPage);

        // Store this cache key in our tracker
        $existingKeys = Cache::get('campaign_cache_keys', []);
        if (!in_array($cacheKey, $existingKeys)) {
            $existingKeys[] = $cacheKey;
            Cache::forever('campaign_cache_keys', $existingKeys);
        }

        return $cacheKey;
    }

    /**
     * Fetch campaigns from database using QueryBuilder
     *
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    private function fetchCampaignsFromDatabase(array $queryParams, int $perPage): LengthAwarePaginator
    {
        $query = Campaign::query()
            ->with(['association', 'donationCategory'])
            ->where('status', 'active')
            ->where('end_date', '>=', now()->format('Y-m-d'));

        return QueryBuilder::for($query)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('donation_category_id'),
                AllowedFilter::exact('association_id'),
                AllowedFilter::exact('donation_type'),
                AllowedFilter::callback('min_amount', fn ($query, $value) =>
                    $query->where('goal_amount', '>=', $value)
                ),
                AllowedFilter::callback('max_amount', fn ($query, $value) =>
                    $query->where('goal_amount', '<=', $value)
                ),
                AllowedFilter::callback('start_date_after', fn ($query, $value) =>
                    $query->where('start_date', '>=', $value)
                ),
                AllowedFilter::callback('end_date_before', fn ($query, $value) =>
                    $query->where('end_date', '<=', $value)
                ),
            ])
            ->allowedSorts([
                'name',
                'created_at',
                'start_date',
                'end_date',
                'goal_amount',
                'collected_amount'
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage)
            ->appends($queryParams);
    }
}
