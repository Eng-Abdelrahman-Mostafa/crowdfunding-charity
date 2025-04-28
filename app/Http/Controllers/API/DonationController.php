<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\DonationResource;
use App\Http\Resources\API\UserDonationResource;
use App\Services\DonationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\API\UserDonationsRequest;

class DonationController extends Controller
{
    /**
     * @var DonationService
     */
    protected $donationService;
    
    /**
     * DonationController constructor.
     *
     * @param DonationService $donationService
     */
    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }
    
    /**
     * Display a listing of donations with filtering and pagination.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $donations = $this->donationService->getAllDonations($request->all(), $perPage);
            
            return DonationResource::collection($donations);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve donations',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display a listing of the authenticated user's donations with filtering and pagination.
     *
     * @param UserDonationsRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function userDonations(UserDonationsRequest $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $donations = $this->donationService->getUserDonations($request->all(), $perPage);
            
            return UserDonationResource::collection($donations);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve your donations',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
