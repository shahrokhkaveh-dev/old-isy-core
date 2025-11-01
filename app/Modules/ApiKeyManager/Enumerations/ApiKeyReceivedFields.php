<?php

namespace App\Modules\ApiKeyManager\Enumerations;

enum ApiKeyReceivedFields: string
{
    case API_KEY = 'api_key';
    case SOURCE_SITE = 'source_site';
}
