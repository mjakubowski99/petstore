<?php

namespace App\Providers;

use App\Contracts\PetStore\IPetStoreApi;
use App\PetStore\Contracts\IPetStoreApiClient;
use App\PetStore\PetStoreApi;
use App\PetStore\PetStoreApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IPetStoreApiClient::class, PetStoreApiClient::class);
        $this->app->bind(IPetStoreApi::class, PetStoreApi::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
