<?php

declare(strict_types=1);

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class EditPetRequest extends FormRequest
{
    public function getId(): int
    {
        return (int) $this->route('petId');
    }
}
