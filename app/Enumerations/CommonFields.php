<?php

namespace App\Enumerations;

enum CommonFields: string
{
    case ID = 'id';
    case CREATED_AT = 'created_at';
    case UPDATED_AT = 'updated_at';
    case DELETED_AT = 'deleted_at';
    case CREATED_BY = 'created_by';
    case UPDATED_BY = 'updated_by';
    case DELETED_BY = 'deleted_by';
}
