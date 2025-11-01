<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Slide extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     * Casts JSON fields to arrays.
     *
     * @var array
     */
    protected $casts = [
        'title_position' => 'array',
        'text_position' => 'array',
    ];

    /**
     * Attributes that are translatable.
     *
     * @var array
     */
    protected array $translatable = ['title', 'text'];

    protected $with = ['translation', 'file'];

    /**
     * Get the slider that owns the slide.
     * Defines an inverse one-to-many relationship with the Slider model.
     */
    public function slider(): BelongsTo
    {
        return $this->belongsTo(Slider::class);
    }

    /**
     * Get the file associated with the slide.
     * Defines a polymorphic one-to-one relationship with the File model.
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
