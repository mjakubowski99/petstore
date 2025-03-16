<?php

declare(strict_types=1);

namespace App\PetStore\Contracts;

interface IResponse
{
    public function success(): bool;
    public function getStatusCode(): int;
    public function getBody(): array;
}
