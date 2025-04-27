<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\DonationCategoryResource;
use App\Services\DonationCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DonationCategoryController extends Controller
{
    /**
     * @var \App\Services\DonationCategoryService
     */
    protected $donationCategoryService;

    /**
     * DonationCategoryController constructor.
     *
     * @param \App\Services\DonationCategoryService $donationCategoryService
     */
    public function __construct(\App\Services\DonationCategoryService $donationCategoryService)
    {
        $this->donationCategoryService = $donationCategoryService;
    }

    /**
     * Display a listing of the donation categories.
     *
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index()
    {
        try {
            $categories = $this->donationCategoryService->getAllCategories();

            return DonationCategoryResource::collection($categories);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve donation categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
