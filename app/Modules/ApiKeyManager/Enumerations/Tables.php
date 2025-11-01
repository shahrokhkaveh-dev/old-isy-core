<?php

namespace App\Modules\ApiKeyManager\Enumerations;

enum Tables: string
{
    case API_KEY_ISSUED = 'api_keys_issued';
    case API_KEY_RECEIVED = 'api_keys_received';
    case API_KEY_LOGS = 'api_key_logs';
}
