<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Contracts\PetStore\IPet;

class UpdatePetRequest extends StorePetRequest implements IPet
{
    public function getId(): int
    {
        return (int) $this->route('petId');
    }
}
