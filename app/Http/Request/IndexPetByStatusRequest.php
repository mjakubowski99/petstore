<?php

namespace App\Http\Request;

use App\PetStore\PetStatus;
use Illuminate\Foundation\Http\FormRequest;

class IndexPetByStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string'],
        ];
    }

    public function getPetStatus(): PetStatus
    {
        return $this->input('status', PetStatus::PENDING);
    }
}
