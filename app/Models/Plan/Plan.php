<?php

namespace App\Models\Plan;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory, HasTranslations;
    /*
    name	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop
	3	period	int		UNSIGNED	No	None			Change Change	Drop Drop
	4	price	bigint			No	0			Change Change	Drop Drop
	5	showPrice	bigint			No	0			Change Change	Drop Drop
	6	discount_type	tinyint			Yes	NULL	0->percent and 1->const		Change Change	Drop Drop
	7	discont_percenet	int			Yes	NULL			Change Change	Drop Drop
	8	discont_const	bigint			Yes	NULL			Change Change	Drop Drop
	9	max_discont_percenet	bigint			Yes	NULL			Change Change	Drop Drop
	10	discount_expired_time	timestamp			Yes	NULL			Change Change	Drop Drop
	11	status	tinyint			No	1			Change Change	Drop Drop
	12	created_at	timestamp			Yes	NULL			Change Change	Drop Drop
	13	updated_at	timestamp			Yes	NULL			Change Change	Drop Drop
	14	plan_type	tinyint			No	1			Change Change	Drop Drop

    */

    protected $fillable = [
        'period',
        'price',
        'showPrice',
        'discount_type',
        'discont_percenet',
        'discont_const',
        'max_discont_percenet',
        'discount_expired_time',
        'status',
        'created_at',
        'updated_at',
        'plan_type',
    ];

    protected array $translatable = ['name'];

    public function attributes(){
        return $this->belongsToMany(Attribute::class , 'plan_attribute');
    }
}
