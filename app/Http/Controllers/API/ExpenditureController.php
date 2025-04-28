<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ExpenditureResource;
use App\Services\ExpenditureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExpenditureController extends Controller
{
    /**
     * @var ExpenditureService
     */
    protected $expenditureService;
    
    /**
     * ExpenditureController constructor.
     *
     * @param ExpenditureService $expenditureService
     */
    public function __construct(ExpenditureService $expenditureService)
    {
        $this->expenditureService = $expenditureService;
    }
    
    /**
     * Display a listing of expenditures with filtering and pagination.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $expenditures = $this->expenditureService->getAllExpenditures($request->all(), $perPage);
            
            return ExpenditureResource::collection($expenditures);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve expenditures',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
