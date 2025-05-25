<?php

namespace App\Services;

use App\Repository\ResidentRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResidentService
{
    protected $residentRepository;


    public function __construct(ResidentRepository $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }

    public function getAllResidents(array $filters = [])
    {
        return $this->residentRepository->getAll($filters);
    }

    public function getResidentById($id)
    {
        $resident = $this->residentRepository->find($id);

        if ($resident && $resident->id_card_photo) {
            try {
                if (Storage::disk('public')->exists($resident->id_card_photo)) {
                    $imageData = Storage::disk('public')->get($resident->id_card_photo);
                    $mimeType = Storage::disk('public')->mimeType($resident->id_card_photo);
                    $resident->id_card_photo = "data:{$mimeType};base64," . base64_encode($imageData);
                } else {
                    Log::error("File not found in storage: {$resident->id_card_photo}");
                    $resident->id_card_photo = null;
                }
            } catch (Exception $e) {
                Log::error("Error processing image: " . $e->getMessage());
                $resident->id_card_photo = null;
            }
        }

        return $resident;
    }

    public function storeResident($request)
    {
        $data = $request->all();
        if ($request->hasFile('id_card_photo')) {
            $data['id_card_photo'] = $request->file('id_card_photo')->store('ktp', 'public');
        }

        return $this->residentRepository->store($data);
    }

    public function updateResident($request, $id)
    {
        $resident = $this->residentRepository->find($id);
        $data = $request->all();
        Log::info('dataa:', $data); // Perbaikan

        if ($request->hasFile('id_card_photo')) {
            // Delete old image if exists
            if ($resident && $resident->id_card_photo) {
                Storage::disk('public')->delete($resident->id_card_photo);
            }

            // Store new image
            $data['id_card_photo'] = $request->file('id_card_photo')->store('ktp', 'public');
        }

        return $this->residentRepository->update($data, $id);
    }

    public function deleteResident($id)
    {
        $resident = $this->residentRepository->find($id);

        if ($resident && $resident->id_card_photo) {
            Storage::disk('public')->delete($resident->id_card_photo);
        }

        return $this->residentRepository->delete($id);
    }
}