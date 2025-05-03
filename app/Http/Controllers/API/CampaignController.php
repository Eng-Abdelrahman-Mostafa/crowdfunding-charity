<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CampaignResource;
use App\Http\Resources\API\DetailedCampaignResource;
use App\Http\Resources\API\DonationResource;
use App\Http\Resources\API\ExpenditureResource;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\DonationService;
use App\Services\ExpenditureService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CampaignController extends Controller
{
    /**
     * @var CampaignService
     */
    protected $campaignService;

    /**
     * @var DonationService
     */
    protected $donationService;

    /**
     * @var ExpenditureService
     */
    protected $expenditureService;

    /**
     * CampaignController constructor.
     *
     * @param CampaignService $campaignService
     * @param DonationService $donationService
     * @param ExpenditureService $expenditureService
     */
    public function __construct(
        CampaignService $campaignService,
        DonationService $donationService,
        ExpenditureService $expenditureService
    ) {
        $this->campaignService = $campaignService;
        $this->donationService = $donationService;
        $this->expenditureService = $expenditureService;
    }

    /**
     * Display a listing of active campaigns.
     *
     * Retrieves a paginated list of all active campaigns.
     *
     * @group Campaign Management
     * @LRDparam  per_page int Number of items per page. Default: 15
     * @LRDparam page int The page number. Default: 1
     * @LRDparam sort string Field to sort by (prefix with - for descending). Available fields: name, created_at, start_date, end_date, goal_amount, collected_amount. Example: -created_at
     * @LRDparam filter[name] string Filter by campaign name (partial match). Example: School
     * @LRDparam filter[donation_category_id] int Filter by donation category ID (exact match). Example: 1
     * @LRDparam filter[association_id] int Filter by association ID (exact match). Example: 3
     * @LRDparam filter[donation_type] string Filter by donation type (exact match). Example: one_time
     * @LRDparam filter[min_amount] numeric Filter by minimum goal amount. Example: 1000
     * @LRDparam filter[max_amount] numeric Filter by maximum goal amount. Example: 5000
     * @LRDparam filter[start_date_after] date Filter by start date (after). Format: Y-m-d. Example: 2023-01-01
     * @LRDparam filter[end_date_before] date Filter by end date (before). Format: Y-m-d. Example: 2023-12-31
     *
     * @LRDresponses  200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Help Build a School",
     *       "description": "Campaign to build a new school in rural area",
     *       "goal_amount": 50000,
     *       "collected_amount": 35000,
     *       "start_date": "2023-01-01",
     *       "end_date": "2023-12-31",
     *       "status": "active",
     *       "donation_type": "one_time",
     *       "donation_category": {
     *         "id": 1,
     *         "name": "Education"
     *       },
     *       "association": {
     *         "id": 1,
     *         "name": "Education For All"
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/campaigns?page=1",
     *     "last": "http://example.com/api/campaigns?page=5",
     *     "prev": null,
     *     "next": "http://example.com/api/campaigns?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 5,
     *     "path": "http://example.com/api/campaigns",
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 75
     *   }
     * }
     *
     * @LRDresponses 500 {
     *   "message": "Failed to retrieve campaigns",
     *   "error": "Error message"
     * }
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     *
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $campaigns = $this->campaignService->getActiveCampaigns($request->all(), $perPage);

            return CampaignResource::collection($campaigns);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve campaigns',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display detailed information for a specific campaign.
     *
     * Retrieves comprehensive details for a campaign including association,
     * donation category, creator, recent donations, and expenditures.
     *
     * @group Campaign Management
     * @urlParam id required The ID of the campaign. Example: 1
     *
     * @LRDresponses 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "Help Build a School",
     *     "description": "Campaign to build a new school in rural area",
     *     "goal_amount": 50000,
     *     "collected_amount": 35000,
     *     "start_date": "2023-01-01",
     *     "end_date": "2023-12-31",
     *     "status": "active",
     *     "donation_type": "one_time",
     *     "image_url": "https://example.com/campaigns/1.jpg",
     *     "donation_category": {
     *       "id": 1,
     *       "name": "Education"
     *     },
     *     "association": {
     *       "id": 1,
     *       "name": "Education For All"
     *     },
     *     "creator": {
     *       "id": 1,
     *       "name": "John Doe"
     *     },
     *     "recent_donations": [
     *       {
     *         "id": 5,
     *         "amount": 1000,
     *         "date": "2023-05-15T14:30:00Z",
     *         "donor": {
     *           "id": 3,
     *           "name": "Jane Smith"
     *         }
     *       }
     *     ],
     *     "recent_expenditures": [
     *       {
     *         "id": 2,
     *         "amount": 5000,
     *         "description": "Land acquisition",
     *         "date": "2023-02-10"
     *       }
     *     ]
     *   }
     * }
     *
     * @LRDresponses 404 {
     *   "message": "Campaign not found"
     * }
     *
     * @LRDresponses 500 {
     *   "message": "Failed to retrieve campaign details",
     *   "error": "Error message"
     * }
     *
     * @param int $id
     * @return DetailedCampaignResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $campaign = $this->campaignService->getCampaignById($id);

            return new DetailedCampaignResource($campaign);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Campaign not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve campaign details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display donations for a specific campaign.
     *
     * Retrieves a paginated list of donations for a particular campaign.
     *
     * @group Campaign Management
     * @urlParam id required The ID of the campaign. Example: 1
     * @LRDparam per_page int Number of items per page. Default: 15
     * @LRDparam page int The page number. Default: 1
     * @LRDparam sort string Field to sort by (prefix with - for descending). Available fields: amount, created_at, donation_date. Example: -amount
     * @LRDparam filter[min_amount] numeric Filter by minimum donation amount. Example: 100
     * @LRDparam filter[max_amount] numeric Filter by maximum donation amount. Example: 1000
     * @LRDparam filter[date_from] date Filter by donation date (from). Format: Y-m-d. Example: 2023-01-01
     * @LRDparam filter[date_to] date Filter by donation date (to). Format: Y-m-d. Example: 2023-12-31
     * @LRDparam filter[donor_name] string Filter by donor name (partial match). Example: John
     *
     * @LRDresponses 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "amount": 500,
     *       "date": "2023-05-01T10:00:00Z",
     *       "payment_status": "success",
     *       "payment_method": "credit_card",
     *       "donor": {
     *         "id": 2,
     *         "name": "Jane Doe",
     *         "email": "jane@example.com"
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/campaigns/1/donations?page=1",
     *     "last": "http://example.com/api/campaigns/1/donations?page=3",
     *     "prev": null,
     *     "next": "http://example.com/api/campaigns/1/donations?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 3,
     *     "path": "http://example.com/api/campaigns/1/donations",
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 45
     *   }
     * }
     *
     * @LRDresponses 404 {
     *   "message": "Campaign not found"
     * }
     *
     * @LRDresponses 500 {
     *   "message": "Failed to retrieve campaign donations",
     *   "error": "Error message"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function donations(Request $request, $id)
    {
        try {
            // Verify campaign exists first
            $campaign = Campaign::findOrFail($id);

            $perPage = $request->get('per_page', 15);
            $donations = $this->donationService->getCampaignDonations($id, $request->all(), $perPage);

            return DonationResource::collection($donations);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Campaign not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve campaign donations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display expenditures for a specific campaign.
     *
     * Retrieves a paginated list of expenditures for a particular campaign.
     *
     * @group Campaign Management
     * @urlParam id required The ID of the campaign. Example: 1
     * @LRDparam per_page int Number of items per page. Default: 15
     * @LRDparam page int The page number. Default: 1
     * @LRDparam sort string Field to sort by (prefix with - for descending). Available fields: amount, date, created_at. Example: -date
     * @LRDparam filter[min_amount] numeric Filter by minimum expenditure amount. Example: 500
     * @LRDparam filter[max_amount] numeric Filter by maximum expenditure amount. Example: 5000
     * @LRDparam filter[date_from] date Filter by expenditure date (from). Format: Y-m-d. Example: 2023-01-01
     * @LRDparam filter[date_to] date Filter by expenditure date (to). Format: Y-m-d. Example: 2023-12-31
     * @LRDparam filter[description] string Filter by description (partial match). Example: materials
     *
     * @LRDresponses 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "amount": 2500,
     *       "description": "Building materials purchase",
     *       "date": "2023-02-15",
     *       "receipt_url": "https://example.com/receipts/exp1.pdf",
     *       "notes": "Invoice #12345"
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/campaigns/1/expenditures?page=1",
     *     "last": "http://example.com/api/campaigns/1/expenditures?page=2",
     *     "prev": null,
     *     "next": "http://example.com/api/campaigns/1/expenditures?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 2,
     *     "path": "http://example.com/api/campaigns/1/expenditures",
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 25
     *   }
     * }
     *
     * @LRDresponses 404 {
     *   "message": "Campaign not found"
     * }
     *
     * @LRDresponses 500 {
     *   "message": "Failed to retrieve campaign expenditures",
     *   "error": "Error message"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function expenditures(Request $request, $id)
    {
        try {
            // Verify campaign exists first
            $campaign = Campaign::findOrFail($id);

            $perPage = $request->get('per_page', 15);
            $expenditures = $this->expenditureService->getCampaignExpenditures($id, $request->all(), $perPage);

            return ExpenditureResource::collection($expenditures);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Campaign not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve campaign expenditures',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
