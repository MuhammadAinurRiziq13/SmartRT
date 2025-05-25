<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyFeeRequest;
use App\Http\Requests\UpdateMonthlyFeeRequest;
use App\Services\MonthlyFeeService;
use Exception;
use Illuminate\Support\Facades\Log;

class MonthlyFeeController extends Controller
{
    protected $monthlyFeeService;

    public function __construct(MonthlyFeeService $monthlyFeeService)
    {
        $this->monthlyFeeService = $monthlyFeeService;
    }

    public function index()
    {
        try {
            $filters = [
                'search' => request('search'),
                'perPage' => request('perPage', 10),
                'sortBy' => request('sortBy', 'created_at'),
                'sortDir' => request('sortDir', 'desc'),
            ];
            $fees = $this->monthlyFeeService->getAllMonthlyFees($filters);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $fees, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching monthly fees', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function show($id)
    {
        try {
            $fee = $this->monthlyFeeService->getMonthlyFeeById($id);
            if (!$fee) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: 'Monthly fee not found', statusCode: 404);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $fee, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching monthly fee detail', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function store(StoreMonthlyFeeRequest $request)
    {
        try {
            $fee = $this->monthlyFeeService->storeMonthlyFee($request);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $fee, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error creating monthly fee', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->monthlyFeeService->deleteMonthlyFee($id);
            if (!$result) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: 'Monthly fee not found', statusCode: 404);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: 'Monthly fee deleted', data: null, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error deleting monthly fee', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }
}