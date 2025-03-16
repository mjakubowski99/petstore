<?php

namespace App\Contracts\PetStore;

use App\PetStore\PetStatus;
use Illuminate\Http\UploadedFile;

interface IPetStoreApi
{
    /** @return IPet[] */
    public function findPetsByStatus(PetStatus $status): array;
    public function addPet(IPet $pet): bool;
    public function updatePet(IPet $pet): bool;
    public function deletePet(int $id): bool;
    public function uploadPetImage(int $id, UploadedFile $file): bool;
}
