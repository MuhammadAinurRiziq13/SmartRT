<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Services\ExpenseService;
use App\Helper\ApiResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class ExpenseController extends Controller
{
    protected $expenseService;
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        try {
            $filters = [
                'search' => request('search'),
                'perPage' => request('perPage', 10),
                'sortBy' => request('sortBy', 'date'),
                'sortDir' => request('sortDir', 'desc'),
            ];
            $expenses = $this->expenseService->getAllExpenses($filters);
            return ApiResponse::success(
                status: self::SUCCESS_STATUS,
                message: self::SUCCESS_MESSAGE,
                data: $expenses,
                statusCode: self::SUCCESS
            );
        } catch (Exception $e) {
            Log::error('Error fetching expenses', ['error' => $e->getMessage()]);
            return ApiResponse::error(
                status: self::ERROR_STATUS,
                message: self::EXCEPTION_MESSAGE,
                statusCode: self::ERROR
            );
        }
    }

    public function store(StoreExpenseRequest $request)
    {
        try {
            $expense = $this->expenseService->storeExpense($request);
            return ApiResponse::success(
                status: self::SUCCESS_STATUS,
                message: self::SUCCESS_MESSAGE,
                data: $expense,
                statusCode: self::SUCCESS
            );
        } catch (Exception $e) {
            Log::error('Error creating expense', ['error' => $e->getMessage()]);
            return ApiResponse::error(
                status: self::ERROR_STATUS,
                message: self::EXCEPTION_MESSAGE,
                statusCode: self::ERROR
            );
        }
    }
}