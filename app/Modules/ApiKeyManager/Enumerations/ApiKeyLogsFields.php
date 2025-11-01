<?php

namespace App\Modules\ApiKeyManager\Enumerations;

enum ApiKeyLogsFields:string
{
    case API_KEY = 'api_key';
    case ENDPOINT = 'endpoint';
    case IP_ADDRESS = 'ip_address';
}
