<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\IndexDataResource;
use App\Services\IndexDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexDataController extends Controller
{
    protected $indexDataService;

    /**
     * Constructor
     * 
     * @param IndexDataService $indexDataService
     */
    public function __construct(IndexDataService $indexDataService)
    {
        $this->indexDataService = $indexDataService;
    }

    /**
     * Get index data
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->indexDataService->getIndexData();
        return response()->json(new IndexDataResource($data));
    }
}
