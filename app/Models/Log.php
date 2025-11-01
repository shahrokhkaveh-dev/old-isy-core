<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip', 'mac', 'agent', 'controller', 'method', 'input', 'output', 'route', 'http_method', 'referer'];
}
