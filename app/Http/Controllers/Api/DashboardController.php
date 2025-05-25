<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function summary(Request $request): JsonResponse
    {
        $year = $request->query('year', now()->year);
        $data = $this->dashboardService->getMonthlySummary($year);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function detail(Request $request): JsonResponse
    {
        $month = $request->query('month');
        $year = $request->query('year');

        if (!$month || !$year) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter month dan year wajib diisi.',
            ], 422);
        }

        $data = $this->dashboardService->getMonthlyDetail($month, $year);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}