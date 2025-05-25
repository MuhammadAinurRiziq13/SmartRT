<?php
namespace App\Repository;

use App\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseRepository
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Expense::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('description', 'like', "%{$search}%");
        }

        if (!empty($filters['sortBy']) && !empty($filters['sortDir'])) {
            $query->orderBy($filters['sortBy'], $filters['sortDir']);
        }

        $perPage = $filters['perPage'] ?? 10;

        return $query->paginate($perPage);
    }

    public function store(array $data)
    {
        return Expense::create($data);
    }
}