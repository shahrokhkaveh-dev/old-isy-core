<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BrandType extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'brand_types';
    protected array $translatable = [
        'name'
    ];

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }
}
