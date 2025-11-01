<?php

namespace App\Modules\ApiKeyManager\Providers;

use App\Modules\ApiKeyManager\Service\ApiKeyService;
use Illuminate\Support\ServiceProvider;
use App\Modules\ApiKeyManager\Middleware\VerifyApiKey;

class ApiKeyManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
//        $this->app->bind(
//            ApiKeyService::class,
//            ApiKeyService::class
//        );
//        $this->app->singleton(VerifyApiKey::class, function ($app){
//            return new VerifyApiKey();
//        });
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
