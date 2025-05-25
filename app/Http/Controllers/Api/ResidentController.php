<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Services\ResidentService;
use Exception;
use Illuminate\Support\Facades\Log;

class ResidentController extends Controller
{
    protected $residentService;

    public function __construct(ResidentService $residentService)
    {
        $this->residentService = $residentService;
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

            $residents = $this->residentService->getAllResidents($filters);

            return ApiResponse::success(
                status: self::SUCCESS_STATUS,
                message: self::SUCCESS_MESSAGE,
                data: $residents,
                statusCode: self::SUCCESS
            );
        } catch (Exception $e) {
            Log::error('Error fetching residents', ['error' => $e->getMessage()]);
            return ApiResponse::error(
                status: self::ERROR_STATUS,
                message: self::EXCEPTION_MESSAGE,
                statusCode: self::ERROR
            );
        }
    }

    public function show($id)
    {
        try {
            $resident = $this->residentService->getResidentById($id);
            if (!$resident) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: 'Resident not found', statusCode: 404);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $resident, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error fetching resident detail', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function store(StoreResidentRequest $request)
    {
        try {
            $resident = $this->residentService->storeResident($request);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $resident, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error creating resident', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function update(UpdateResidentRequest $request, $id)
    {
        try {
            $resident = $this->residentService->updateResident($request, $id);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $resident, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error updating resident', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->residentService->deleteResident($id);
            if (!$deleted) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: 'Resident not found', statusCode: 404);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: 'Resident deleted successfully', data: null, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Error deleting resident', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }
}