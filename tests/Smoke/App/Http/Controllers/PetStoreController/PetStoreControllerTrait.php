<?php

declare(strict_types=1);

namespace Tests\Smoke\App\Http\Controllers\PetStoreController;

use Illuminate\Support\Facades\Http;

trait PetStoreControllerTrait
{
    public function fakePetStoreApi(string $url = '*', array $response_data = [], int $status_code = 200): void
    {
        Http::fake([
            $url => Http::response($response_data, $status_code),
        ]);
    }
}
