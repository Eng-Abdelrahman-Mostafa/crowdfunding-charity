<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CampaignResource;
use App\Services\CampaignService;
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
     * CampaignController constructor.
     *
     * @param \App\Services\CampaignService $campaignService
     */
    public function __construct(\App\Services\CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
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
}
