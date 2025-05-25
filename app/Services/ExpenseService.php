<?php

namespace App\Services;

use App\Repository\ExpenseRepository;

class ExpenseService
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function getAllExpenses(array $filters = [])
    {
        return $this->expenseRepository->getAll($filters);
    }

    public function storeExpense($request)
    {
        return $this->expenseRepository->store($request->all());
    }
}