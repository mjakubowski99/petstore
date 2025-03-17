<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PetStoreApiException extends HttpException
{
    private array $body;
    public function __construct(int $statusCode, string $message = "", array $body = [], \Throwable $previous = null)
    {
        parent::__construct($statusCode, $message, $previous);
        $this->body = $body;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
