<?php

namespace App\Repositories;

use App\Enums\CommonFields;
use App\Models\Ticket;

class TicketRepository extends BaseRepository
{
    public function __construct()
    {
        $model = new Ticket();
        parent::__construct($model);
    }

    public function show($uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }
}
