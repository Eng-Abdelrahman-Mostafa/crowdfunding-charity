<?php

namespace App\Services;

use App\Models\Association;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Expenditure;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get stats for admin dashboard
     *
     * @return array
     */
    public function getAdminStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_donors' => User::where('type', 'donor')->count(),
            'total_associations' => Association::count(),
            'total_campaigns' => Campaign::count(),
            'total_donations' => Donation::count(),
            'total_donation_amount' => Donation::where('payment_status', 'success')->sum('amount'),
            'goal_amount' => Campaign::sum('goal_amount'),
            'expenditures_amount' => Expenditure::sum('amount'),
            'total_withdrawals' => Withdrawal::where('status', 'success')->sum('amount'),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
        ];
    }

    /**
     * Get stats for association manager dashboard
     *
     * @param int $userId
     * @return array
     */
    public function getAssociationManagerStats(int $userId): array
    {
        // Get associations managed by this user with explicit column selection
        $associationIds = User::find($userId)->associations()
            ->select('associations.id')
            ->pluck('associations.id')
            ->toArray();

        return [
            'total_associations' => count($associationIds),
            'total_campaigns' => Campaign::whereIn('association_id', $associationIds)->count(),
            'total_donations' => Donation::whereHas('campaign', function ($query) use ($associationIds) {
                $query->whereIn('association_id', $associationIds);
            })->count(),
            'total_donation_amount' => Donation::whereHas('campaign', function ($query) use ($associationIds) {
                $query->whereIn('association_id', $associationIds);
            })->where('payment_status', 'success')->sum('amount'),
            'goal_amount' => Campaign::whereIn('association_id', $associationIds)->sum('goal_amount'),
            'expenditures_amount' => Expenditure::whereHas('campaign', function ($query) use ($associationIds) {
                $query->whereIn('association_id', $associationIds);
            })->sum('amount'),
            'total_withdrawals' => Withdrawal::whereIn('association_id', $associationIds)
                ->where('status', 'success')->sum('amount'),
            'pending_withdrawals' => Withdrawal::whereIn('association_id', $associationIds)
                ->where('status', 'pending')->count(),
        ];
    }

    /**
     * Get monthly donations data for charts
     *
     * @param array|null $associationIds
     * @return array
     */
    public function getMonthlyDonationsData(?array $associationIds = null): array
    {
        $query = Donation::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('COUNT(*) as count')
        )
            ->where('payment_status', 'success')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month');

        // Filter by associations if provided
        if ($associationIds) {
            $query->whereHas('campaign', function ($q) use ($associationIds) {
                $q->whereIn('association_id', $associationIds);
            });
        }

        $monthlyData = $query->get();

        // Format for chart
        $months = [];
        $amounts = [];
        $counts = [];

        foreach (range(1, 12) as $month) {
            $monthName = Carbon::create(null, $month)->format('M');
            $months[] = $monthName;

            $monthData = $monthlyData->first(function ($item) use ($month) {
                return $item->month == $month;
            });

            $amounts[] = $monthData ? (float) $monthData->total_amount : 0;
            $counts[] = $monthData ? (int) $monthData->count : 0;
        }

        return [
            'months' => $months,
            'amounts' => $amounts,
            'counts' => $counts
        ];
    }

    /**
     * Get campaigns by status
     *
     * @param array|null $associationIds
     * @return array
     */
    public function getCampaignsByStatus(?array $associationIds = null): array
    {
        $query = Campaign::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status');

        // Filter by associations if provided
        if ($associationIds) {
            $query->whereIn('association_id', $associationIds);
        }

        $result = $query->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            })
            ->toArray();

        // Ensure all statuses are represented
        $statuses = ['active', 'inactive'];
        foreach ($statuses as $status) {
            if (!isset($result[$status])) {
                $result[$status] = 0;
            }
        }

        return $result;
    }

    /**
     * Get top campaigns by donations
     *
     * @param array|null $associationIds
     * @param int $limit
     * @return Collection
     */
    public function getTopCampaigns(?array $associationIds = null, int $limit = 5): Collection
    {
        $query = Campaign::withSum(['donations' => function ($query) {
            $query->where('payment_status', 'success');
        }], 'amount')
            ->orderByDesc('donations_sum_amount')
            ->limit($limit);

        // Filter by associations if provided
        if ($associationIds) {
            $query->whereIn('association_id', $associationIds);
        }

        return $query->get(['id', 'name', 'goal_amount']);
    }

    /**
     * Get recent donations
     *
     * @param array|null $associationIds
     * @param int $limit
     * @return Collection
     */
    public function getRecentDonations(?array $associationIds = null, int $limit = 5): Collection
    {
        $query = Donation::with(['donor:id,name', 'campaign:id,name'])
            ->where('payment_status', 'success')
            ->orderByDesc('created_at')
            ->limit($limit);

        // Filter by associations if provided
        if ($associationIds) {
            $query->whereHas('campaign', function ($q) use ($associationIds) {
                $q->whereIn('association_id', $associationIds);
            });
        }

        return $query->get(['id', 'donor_id', 'campaign_id', 'amount', 'created_at']);
    }

    /**
     * Get recent withdrawals
     *
     * @param array|null $associationIds
     * @param int $limit
     * @return Collection
     */
    public function getRecentWithdrawals(?array $associationIds = null, int $limit = 5): Collection
    {
        $query = Withdrawal::with(['association:id,name', 'campaign:id,name'])
            ->orderByDesc('created_at')
            ->limit($limit);

        // Filter by associations if provided
        if ($associationIds) {
            $query->whereIn('association_id', $associationIds);
        }

        return $query->get(['id', 'association_id', 'campaign_id', 'amount', 'status', 'created_at']);
    }

    /**
     * Get donations by category
     *
     * @param array|null $associationIds
     * @return array
     */
    public function getDonationsByCategory(?array $associationIds = null): array
    {
        $query = Donation::select(
            'donation_categories.id',
            'donation_categories.name',
            DB::raw('SUM(donations.amount) as total_amount'),
            DB::raw('COUNT(donations.id) as count')
        )
            ->join('campaigns', 'donations.campaign_id', '=', 'campaigns.id')
            ->join('donation_categories', 'campaigns.donation_category_id', '=', 'donation_categories.id')
            ->where('donations.payment_status', 'success')
            ->groupBy('donation_categories.id', 'donation_categories.name')
            ->orderByDesc('total_amount');

        // Filter by associations if provided
        if ($associationIds) {
            $query->whereIn('campaigns.association_id', $associationIds);
        }

        // Return data formatted for charts
        $result = $query->get();
        return [
            'labels' => $result->pluck('name')->toArray(),
            'data' => $result->pluck('total_amount')->toArray(),
            'counts' => $result->pluck('count')->toArray(),
        ];
    }
}
