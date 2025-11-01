<?php

namespace App\Modules\ApiKeyManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\ApiKeyManager\Enumerations\Tables;
use App\Modules\ApiKeyManager\Enumerations\ApiKeyLogsFields;

/**
 * @method static create()
 */
class ApiKeyLog extends Model
{
    protected $table = Tables::API_KEY_LOGS->value;

    protected $fillable = [
        ApiKeyLogsFields::API_KEY->value,
        ApiKeyLogsFields::ENDPOINT->value,
        ApiKeyLogsFields::IP_ADDRESS->value,
    ];
}
