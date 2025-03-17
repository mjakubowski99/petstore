<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UploadImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo' => ['file'],
        ];
    }

    public function getId(): int
    {
        return (int) $this->route('petId');
    }

    public function getFile(): UploadedFile
    {
        return $this->file('photo');
    }
}
