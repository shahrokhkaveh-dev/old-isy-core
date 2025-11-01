<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    use HasFactory;
    protected $table = 'brand_personels';
    protected $fillable = [
        'brand_id',
        'role_name',
        'name',
        'phone'
    ];
}
