<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Services\InventoryChartService;
use Illuminate\Http\JsonResponse;

class ChartDataController extends Controller
{
    protected $chartService;

    public function __construct(InventoryChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    public function getWeeklyData(): JsonResponse
    {
        return response()->json($this->chartService->getWeeklySalesPurchases());
    }
}