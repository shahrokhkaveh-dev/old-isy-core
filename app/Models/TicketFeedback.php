<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'ticket_type',
        'admin_id',
        'score',
        'feedback',
    ];
}
