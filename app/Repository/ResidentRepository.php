<?php

namespace App\Repository;

use App\Models\Resident;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ResidentRepository
{
    // public function getAll()
    // {
    //     return Resident::all();
    // }

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Resident::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('resident_status', 'like', "%{$search}%")
                    ->orWhere('marital_status', 'like', "%{$search}%");
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
        return Resident::find($id);
    }

    public function store(array $data)
    {
        return Resident::create($data);
    }

    public function update(array $data, $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->update($data);
        return $resident;
    }

    public function delete($id)
    {
        $resident = Resident::find($id);
        if (!$resident) {
            return false;
        }
        return $resident->delete();
    }
}