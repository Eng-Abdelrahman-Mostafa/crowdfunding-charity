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
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
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
