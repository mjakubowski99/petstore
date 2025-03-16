<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PetStoreApiException extends HttpException
{
    public function __construct(int $statusCode, string $message = "", \Throwable $previous = null)
    {
        parent::__construct($statusCode, $message, $previous);
    }
}
