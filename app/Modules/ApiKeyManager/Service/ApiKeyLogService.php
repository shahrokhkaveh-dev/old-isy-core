<?php

namespace App\Modules\ApiKeyManager\Service;

use App\Modules\ApiKeyManager\Enumerations\ApiKeyLogsFields;
use App\Modules\ApiKeyManager\Models\ApiKeyLog;

class ApiKeyLogService
{
    public function logRequest(string $apiKey, string $endpoint, string $ipAddress):void
    {
        ApiKeyLog::create([
            ApiKeyLogsFields::API_KEY->value => $apiKey,
            ApiKeyLogsFields::ENDPOINT->value => $endpoint,
            ApiKeyLogsFields::IP_ADDRESS->value => $ipAddress
        ]);
    }
}
