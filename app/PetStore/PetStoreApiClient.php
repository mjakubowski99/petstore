<?php

declare(strict_types=1);

namespace App\PetStore;

use App\PetStore\Contracts\IPetStoreApiClient;
use App\PetStore\Contracts\IResponse;
use App\PetStore\Models\Response;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class PetStoreApiClient implements IPetStoreApiClient
{
    private string $base_url;

    public function __construct(private Config $config)
    {
        $this->base_url = $this->config->get('services.petstore.base_url');
    }

    public function get(string $route, array $parameters = [], array $headers = []): IResponse
    {
        $response = $this->buildHttpClient()
            ->withHeaders($headers)
            ->get($this->buildUrl($route, $parameters));

        return new Response($response);
    }

    public function post(string $route, array $body = [], array $parameters = [], array $headers = []): IResponse
    {
        $response = $this->buildHttpClient()
            ->withHeaders($headers)
            ->post($this->buildUrl($route, $parameters), $body);

        return new Response($response);
    }

    public function put(string $route, array $body = [], array $parameters = [], array $headers = []): IResponse
    {
        $response = $this->buildHttpClient()
            ->withHeaders($headers)
            ->put($this->buildUrl($route, $parameters), $body);

        return new Response($response);
    }

    public function delete(string $route, array $parameters = [], array $headers = []): IResponse
    {
        $response = $this->buildHttpClient()
            ->withHeaders($headers)
            ->delete($this->buildUrl($route, $parameters));

        return new Response($response);
    }

    private function buildHttpClient(): PendingRequest
    {
        return Http::timeout(5)
            ->connectTimeout(5)
            ->retry(3, 100, null, false)
            ->acceptJson()
            ->withHeaders([
                'api-key' => $this->config->get('services.petstore.api-key'),
            ]);
    }

    private function buildUrl(string $route, array $parameters = []): string
    {
        return rtrim($this->base_url, '/') . '/' . trim($route, '/') . '?' . Arr::query($parameters);
    }
}
