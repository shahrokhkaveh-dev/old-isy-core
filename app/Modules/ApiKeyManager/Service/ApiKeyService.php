<?php

namespace App\Modules\ApiKeyManager\Service;

use App\Modules\ApiKeyManager\Enumerations\ApiKeyIssuedFields;
use App\Modules\ApiKeyManager\Enumerations\ApiKeyReceivedFields;
use App\Modules\ApiKeyManager\Models\ApiKeyIssued;
use App\Modules\ApiKeyManager\Models\ApiKeyReceived;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ApiKeyService
{
    public function generateApiKey(string $targetSite): string
    {
        $apiKey = Str::random(40);
        $encodedApiKey = Crypt::encryptString($apiKey);
        ApiKeyIssued::create([
            ApiKeyIssuedFields::API_KEY->value => $encodedApiKey,
            ApiKeyIssuedFields::TARGET_SITE->value => $targetSite
        ]);

        return $apiKey;
    }

    public function storeReceivedApiKey(string $apiKey, string $sourceSite): void
    {
        $encryptedApiKey = Crypt::encryptString($apiKey);
        ApiKeyReceived::create([
            ApiKeyReceivedFields::API_KEY->value => $encryptedApiKey,
            ApiKeyReceivedFields::SOURCE_SITE->value => $sourceSite
        ]);
    }
    public function getApiKeyForSite(string $sourceSite): ?string
    {
        $apiKey = ApiKeyReceived::where(ApiKeyReceivedFields::SOURCE_SITE->value, $sourceSite)->first();
        if($apiKey) {
            return Crypt::decryptString($apiKey->getAttribute(ApiKeyReceivedFields::API_KEY->value));
        }
        return null;
    }
}
