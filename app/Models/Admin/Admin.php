<?php

namespace App\Models\Admin;

use App\Enums\Admin\Fields;
use App\Enums\CommonFields;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['fname', 'lname'];

    protected $fillable = [
        CommonFields::USERNAME, Fields::PASSWORD, Fields::FIRST_NAME, Fields::LAST_NAME, Fields::EMAIL, Fields::PHONE,
        Fields::IMAGE, Fields::ROLE, Fields::LAST_LOGIN, Fields::SESSION , Fields::IS_ACTIVE
    ];
}
