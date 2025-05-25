<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Services\HouseService;
use Exception;
use Illuminate\Support\Facades\Log;

class HouseController extends Controller
{
    protected $houseService;

    public function __construct(HouseService $houseService)
    {
        $this->houseService = $houseService;
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
            $houses = $this->houseService->getAllHouses($filters);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $houses, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching houses', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function show($id)
    {
        try {
            $house = $this->houseService->getHouseById($id);
            if (!$house) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: 'House not found', statusCode: 404);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $house, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching house detail', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function store(StoreHouseRequest $request)
    {
        try {
            $house = $this->houseService->storeHouseWithExistingResident($request);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $house, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error creating house', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function update(UpdateHouseRequest $request, $id)
    {
        try {
            $house = $this->houseService->updateHouse($request, $id);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $house, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error updating house', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->houseService->deleteHouse($id);
            if (!$deleted) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: 'House not found', statusCode: 404);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: 'House deleted successfully', data: null, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error deleting house', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function occupancyHistory($id)
    {
        try {
            $history = $this->houseService->getOccupancyHistory($id);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $history, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching occupancy history', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function paymentHistory($id)
    {
        try {
            $history = $this->houseService->getPaymentHistory($id);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $history, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching payment history', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }
}