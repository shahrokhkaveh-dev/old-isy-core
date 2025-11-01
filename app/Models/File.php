<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     * This will automatically add the 'url' attribute when the model is converted to an array/JSON.
     *
     * @var array
     */
    protected $appends = ['url'];

    /**
     * Get the parent model (fileable).
     * Defines the inverse of the polymorphic relationship.
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the full URL for the file.
     * This accessor dynamically generates the URL using Laravel's Storage facade.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
