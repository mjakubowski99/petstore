<?php

declare(strict_types=1);

namespace App\Contracts\PetStore;

use App\Descriptors\PetStatus;
use Illuminate\Http\UploadedFile;

interface IPetStoreApi
{
    /** @return IPet[] */
    public function findPetsByStatus(PetStatus $status): array;
    public function findById(int $id): IPet;
    public function addPet(IPet $pet): IPet;
    public function updatePet(IPet $pet): bool;
    public function deletePet(int $id): bool;
}
