<?php

namespace App\PetStore\Models;

use App\PetStore\Contracts\IResponse;
use Illuminate\Http\Client\Response as IlluminateResponse;

class Response implements IResponse
{
    public function __construct(private IlluminateResponse $response) {}

    public function success(): bool
    {
        return $this->response->successful();
    }

    public function getStatusCode(): int
    {
        return $this->response->status();
    }

    public function getBody(): array
    {
        return $this->response->json();
    }
}
