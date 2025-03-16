<?php

declare(strict_types=1);

namespace App\PetStore\Contracts;

use Illuminate\Http\UploadedFile;

interface IPetStoreApiClient
{
    public function get(string $route, array $parameters = [], array $headers = []): IResponse;
    public function post(string $route, array $body = [], array $parameters = [], array $headers = []): IResponse;
    public function postUpload(string $route, UploadedFile $file, array $body = [], array $parameters = [], array $headers = []): IResponse;
    public function put(string $route, array $body = [], array $parameters = [], array $headers = []): IResponse;
    public function delete(string $route, array $parameters = [], array $headers = []): IResponse;
}
