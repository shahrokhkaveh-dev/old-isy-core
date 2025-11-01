<?php

namespace App\Models\Plan;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['name'];
    protected string $translationModel = AttributeTranslate::class;
    protected string $translationForeignKey = 'attribute_id';

    protected $table = 'plan_attributes';
}
