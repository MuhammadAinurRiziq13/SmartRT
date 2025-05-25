<?php

namespace App\Repository;

use App\Models\MonthlyFee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MonthlyFeeRepository
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = MonthlyFee::with(['house', 'resident']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('resident', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%");
            })->orWhereHas('house', function ($q) use ($search) {
                $q->where('house_number', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['sortBy']) && !empty($filters['sortDir'])) {
            $query->orderBy($filters['sortBy'], $filters['sortDir']);
        }

        $perPage = $filters['perPage'] ?? 10;
        return $query->paginate($perPage);
    }

    public function find($id)
    {
        return MonthlyFee::with(['house', 'resident'])->find($id);
    }

    public function store(array $data)
    {
        return MonthlyFee::create($data);
    }

    public function delete($id)
    {
        $monthlyFee = MonthlyFee::find($id);
        if (!$monthlyFee) {
            return false;
        }
        return $monthlyFee->delete();
    }
}