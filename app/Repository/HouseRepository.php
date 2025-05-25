<?php

namespace App\Repository;

use App\Models\House;
use App\Models\OccupancyHistory;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HouseRepository
{
    // public function getAll()
    // {
    //     $query =  House::with(['currentResident', 'occupancyHistories', 'monthlyFees'])->get();


    // }

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = House::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('house_number', 'like', "%{$search}%")
                    ->orWhere('occupancy_status', 'like', "%{$search}%");
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
        return House::with([
            'occupancyHistories.resident',
            'monthlyFees'
        ])->find($id);
    }

    public function store(array $data)
    {
        return House::create($data);
    }

    public function storeWithMultipleResidents(array $houseData, array $residents)
    {
        return DB::transaction(function () use ($houseData, $residents) {
            $house = House::create($houseData);

            foreach ($residents as $entry) {
                OccupancyHistory::create([
                    'house_id' => $house->id,
                    'resident_id' => $entry['resident_id'],
                    'occupancy_type' => $entry['occupancy_type'],
                ]);
            }

            return $house->load(['occupancyHistories']);
        });
    }


    public function update(array $data, $id)
    {
        $house = House::findOrFail($id);
        $house->update($data);
        return $house;
    }

    public function updateWithResidents($id, array $houseData, ?array $residents = null)
    {
        return DB::transaction(function () use ($id, $houseData, $residents) {
            $house = House::findOrFail($id);
            $house->update($houseData);

            if ($residents !== null) {
                // Hapus semua histori lama penghuni rumah ini
                $house->occupancyHistories()->delete();

                // Masukkan ulang histori baru sesuai data terbaru
                foreach ($residents as $entry) {
                    OccupancyHistory::create([
                        'house_id' => $id,
                        'resident_id' => $entry['resident_id'],
                        'occupancy_type' => $entry['occupancy_type'],
                    ]);
                }
            }

            return $house->load(['occupancyHistories.resident']);
        });
    }


    public function delete($id)
    {
        $house = House::find($id);
        if (!$house) {
            return false;
        }

        return $house->delete();
    }

    public function getOccupancyHistory($houseId)
    {
        return House::with('occupancyHistories.resident')->findOrFail($houseId)->occupancyHistories;
    }

    public function getPaymentHistory($houseId)
    {
        return House::with('monthlyFees.resident')->findOrFail($houseId)->monthlyFees;
    }
}