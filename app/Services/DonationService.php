<?php

namespace App\Services;

use App\Models\Donation;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Auth;

class DonationService
{
    /**
     * Get all donations with filters and pagination
     *
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllDonations(array $queryParams = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Donation::query()
            ->with(['donor', 'campaign'])
            ->where('payment_status', 'success');
        
        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('campaign_id'),
                AllowedFilter::exact('donor_id'),
                AllowedFilter::exact('payment_method'),
                AllowedFilter::exact('currency'),
                AllowedFilter::callback('min_amount', fn ($query, $value) => 
                    $query->where('amount', '>=', $value)
                ),
                AllowedFilter::callback('max_amount', fn ($query, $value) => 
                    $query->where('amount', '<=', $value)
                ),
                AllowedFilter::callback('date_from', fn ($query, $value) => 
                    $query->whereDate('created_at', '>=', $value)
                ),
                AllowedFilter::callback('date_to', fn ($query, $value) => 
                    $query->whereDate('created_at', '<=', $value)
                ),
                AllowedFilter::callback('is_anonymous', fn ($query, $value) => 
                    $query->where('donate_anonymously', (bool) $value)
                ),
            ])
            ->allowedSorts([
                'created_at',
                'paid_at',
                'amount'
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage)
            ->appends($queryParams);
    }

    /**
     * Get donations for a specific campaign with filters and pagination
     *
     * @param int $campaignId
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getCampaignDonations(int $campaignId, array $queryParams = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Donation::query()
            ->with(['donor', 'campaign'])
            ->where('campaign_id', $campaignId)
            ->where('payment_status', 'success');
        
        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('donor_id'),
                AllowedFilter::exact('payment_method'),
                AllowedFilter::exact('currency'),
                AllowedFilter::callback('min_amount', fn ($query, $value) => 
                    $query->where('amount', '>=', $value)
                ),
                AllowedFilter::callback('max_amount', fn ($query, $value) => 
                    $query->where('amount', '<=', $value)
                ),
                AllowedFilter::callback('date_from', fn ($query, $value) => 
                    $query->whereDate('created_at', '>=', $value)
                ),
                AllowedFilter::callback('date_to', fn ($query, $value) => 
                    $query->whereDate('created_at', '<=', $value)
                ),
                AllowedFilter::callback('is_anonymous', fn ($query, $value) => 
                    $query->where('donate_anonymously', (bool) $value)
                ),
            ])
            ->allowedSorts([
                'created_at',
                'paid_at',
                'amount'
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage)
            ->appends($queryParams);
    }

    /**
     * Get donations for the authenticated user with filters and pagination
     *
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserDonations(array $queryParams = [], int $perPage = 15): LengthAwarePaginator
    {
        $userId = Auth::id();
        
        $query = Donation::query()
            ->with([
                'campaign', 
                'campaign.association', 
                'campaign.donationCategory'
            ])
            ->where('donor_id', $userId);
        
        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('campaign_id'),
                AllowedFilter::exact('payment_status'),
                AllowedFilter::exact('payment_method'),
                AllowedFilter::exact('currency'),
                AllowedFilter::callback('min_amount', fn ($query, $value) => 
                    $query->where('amount', '>=', $value)
                ),
                AllowedFilter::callback('max_amount', fn ($query, $value) => 
                    $query->where('amount', '<=', $value)
                ),
                AllowedFilter::callback('date_from', fn ($query, $value) => 
                    $query->whereDate('created_at', '>=', $value)
                ),
                AllowedFilter::callback('date_to', fn ($query, $value) => 
                    $query->whereDate('created_at', '<=', $value)
                ),
            ])
            ->allowedSorts([
                'created_at',
                'paid_at',
                'amount'
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage)
            ->appends($queryParams);
    }
}
