<?php

namespace App\Repositories;

use App\Models\Category;

class SubCategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $model = new Category();
        parent::__construct($model);
    }
}
