<?php

namespace App\Services;

use App\Repository\MonthlyFeeRepository;

class MonthlyFeeService
{
    protected $monthlyFeeRepository;

    public function __construct(MonthlyFeeRepository $monthlyFeeRepository)
    {
        $this->monthlyFeeRepository = $monthlyFeeRepository;
    }

    public function getAllMonthlyFees(array $filters = [])
    {
        return $this->monthlyFeeRepository->getAll($filters);
    }

    public function getMonthlyFeeById($id)
    {
        return $this->monthlyFeeRepository->find($id);
    }

    public function storeMonthlyFee($request)
    {
        $request = $request->all();
        return $this->monthlyFeeRepository->store($request);
    }

    public function deleteMonthlyFee($id)
    {
        return $this->monthlyFeeRepository->delete($id);
    }
}