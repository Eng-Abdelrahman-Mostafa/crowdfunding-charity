<?php

namespace App\Services;

use App\Models\Expenditure;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ExpenditureService
{
    /**
     * Get all expenditures with filters and pagination
     *
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllExpenditures(array $queryParams = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Expenditure::query()
            ->with(['campaign', 'user']);
        
        return QueryBuilder::for($query)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('campaign_id'),
                AllowedFilter::exact('created_by'),
                AllowedFilter::callback('min_amount', fn ($query, $value) => 
                    $query->where('amount', '>=', $value)
                ),
                AllowedFilter::callback('max_amount', fn ($query, $value) => 
                    $query->where('amount', '<=', $value)
                ),
                AllowedFilter::callback('date_from', fn ($query, $value) => 
                    $query->whereDate('date', '>=', $value)
                ),
                AllowedFilter::callback('date_to', fn ($query, $value) => 
                    $query->whereDate('date', '<=', $value)
                ),
            ])
            ->allowedSorts([
                'name',
                'date',
                'amount',
                'created_at'
            ])
            ->defaultSort('-date')
            ->paginate($perPage)
            ->appends($queryParams);
    }

    /**
     * Get expenditures for a specific campaign with filters and pagination
     *
     * @param int $campaignId
     * @param array $queryParams
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getCampaignExpenditures(int $campaignId, array $queryParams = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Expenditure::query()
            ->with(['campaign', 'user'])
            ->where('campaign_id', $campaignId);
        
        return QueryBuilder::for($query)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('created_by'),
                AllowedFilter::callback('min_amount', fn ($query, $value) => 
                    $query->where('amount', '>=', $value)
                ),
                AllowedFilter::callback('max_amount', fn ($query, $value) => 
                    $query->where('amount', '<=', $value)
                ),
                AllowedFilter::callback('date_from', fn ($query, $value) => 
                    $query->whereDate('date', '>=', $value)
                ),
                AllowedFilter::callback('date_to', fn ($query, $value) => 
                    $query->whereDate('date', '<=', $value)
                ),
            ])
            ->allowedSorts([
                'name',
                'date',
                'amount',
                'created_at'
            ])
            ->defaultSort('-date')
            ->paginate($perPage)
            ->appends($queryParams);
    }
}
