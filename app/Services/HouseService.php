<?php

namespace App\Services;

use App\Repository\HouseRepository;

class HouseService
{
    protected $houseRepository;

    public function __construct(HouseRepository $houseRepository)
    {
        $this->houseRepository = $houseRepository;
    }

    public function getAllHouses(array $filters = [])
    {
        return $this->houseRepository->getAll($filters);
    }

    public function getHouseById($id)
    {
        return $this->houseRepository->find($id);
    }

    public function storeHouseWithExistingResident($request)
    {
        $residents = $request->residents;

        $houseData = [
            'house_number' => $request->house_number,
            'occupancy_status' => count($residents) > 0 ? 'occupied' : 'vacant',
        ];

        return $this->houseRepository->storeWithMultipleResidents($houseData, $residents);
    }

    public function updateHouse($request, $id)
    {
        $data = $request->only(['house_number', 'occupancy_status']);
        $residents = $request->input('residents');

        return $this->houseRepository->updateWithResidents($id, $data, $residents);
    }


    public function deleteHouse($id)
    {
        return $this->houseRepository->delete($id);
    }

    public function getOccupancyHistory($houseId)
    {
        return $this->houseRepository->getOccupancyHistory($houseId);
    }

    public function getPaymentHistory($houseId)
    {
        return $this->houseRepository->getPaymentHistory($houseId);
    }
}