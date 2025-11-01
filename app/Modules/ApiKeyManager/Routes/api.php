<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ApiKeyManager\Controllers\ApiKeyController;
use App\Modules\ApiKeyManager\Middleware\VerifyApiKey;
Route::prefix('/api-key')->middleware(['auth:sanctum', VerifyApiKey::class])->group(function () {
    Route::post('/generate-api-key', [ApiKeyController::class, 'generateApiKey']);
    Route::post('/store-api-key', [ApiKeyController::class, 'storeReceivedApiKey']);
});
