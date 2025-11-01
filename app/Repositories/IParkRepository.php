<?php

namespace App\Repositories;

use App\Enums\Admin\Fields;
use App\Models\Ipark;

class IParkRepository extends BaseRepository
{
    public function __construct()
    {
        $model = new Ipark();
        parent::__construct($model);
    }
}
