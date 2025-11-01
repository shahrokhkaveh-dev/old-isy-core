<?php

namespace App\Modules\ApiKeyManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\ApiKeyManager\Enumerations\Tables;
use App\Modules\ApiKeyManager\Enumerations\ApiKeyIssuedFields;

/**
 * @method static create(array $array)
 */
class ApiKeyIssued extends Model
{
    protected $table = Tables::API_KEY_ISSUED->value;

    protected $fillable = [
        ApiKeyIssuedFields::API_KEY->value,
        ApiKeyIssuedFields::TARGET_SITE->value,
    ];
}
