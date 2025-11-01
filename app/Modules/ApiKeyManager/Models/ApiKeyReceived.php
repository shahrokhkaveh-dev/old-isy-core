<?php

namespace App\Modules\ApiKeyManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\ApiKeyManager\Enumerations\Tables;
use App\Modules\ApiKeyManager\Enumerations\ApiKeyReceivedFields;

/**
 * @method static create(array $array)
 * @method static where(string $value, string $sourceSite)
 */
class ApiKeyReceived extends Model
{
    protected $table = Tables::API_KEY_RECEIVED->value;

    protected $fillable = [
        ApiKeyReceivedFields::API_KEY->value,
        ApiKeyReceivedFields::SOURCE_SITE->value,
    ];
}
