<?php

namespace App\Modules\ApiKeyManager\Enumerations;

enum ApiKeyIssuedFields: string
{
    case API_KEY = 'api_key';
    case TARGET_SITE = 'target_site';
}
