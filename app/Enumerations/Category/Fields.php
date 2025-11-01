<?php

namespace App\Enumerations\Category;

enum Fields: string
{
    case NAME = 'name';
    case ENAME = 'ename';
    case SLUG = 'slug';
    case DESCRIPTION = 'description';
    case ICONS = 'icons';
    case PARENT_ID = 'parent_id';
    case STATUS = 'status';
    case ORDER = 'order';
    case IMAGES = 'images';
    case IMAGE  = 'image';
    case LEVEL = 'level';
    case PRODUCTS_COUNT = 'products_count';
    case CODE = 'code';
}
