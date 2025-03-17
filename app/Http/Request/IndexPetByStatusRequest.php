<?php

namespace App\Http\Request;

use App\Descriptors\PetStatus;
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
        $status = $this->input('status', PetStatus::DEFAULT->value);

        return PetStatus::from($status);
    }
}
