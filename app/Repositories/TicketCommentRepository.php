<?php

namespace App\Repositories;

use App\Models\TicketComment;

class TicketCommentRepository extends BaseRepository
{
    public function __construct()
    {
        $model = new TicketComment();
        parent::__construct($model);
    }
}
