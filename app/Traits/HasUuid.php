<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait HasUuid
{
    // protected string $uuidField = 'uuid';
    // protected int $uuidVersion = 4;
    // protected int $uuidMaxAttempts = 10;

    public static function bootHasUuid()
    {
        static::creating(function (Model $model) {
            $model->generateUuid();
        });
    }

    protected function generateUuid(): void
    {
        $uuidField = $this->getUuidField();

        if (!empty($this->getAttribute($uuidField))) {
            return;
        }

        $uuid = $this->createUniqueUuid();
        $this->setAttribute($uuidField, $uuid);
    }

    protected function createUniqueUuid(): string
    {
        $attempts = 0;
        $uuidField = $this->getUuidField();
        $uuidMaxAttempts = $this->getUuidMaxAttempts();
        $uuidVersion = $this->getUuidVersion();

        do {
            if ($attempts >= $uuidMaxAttempts) {
                throw new \RuntimeException("Unable to generate a unique UUID after {$uuidMaxAttempts} attempts");
            }

            $uuid = $uuidVersion === 7
                ? (string) Str::orderedUuid()
                : (string) Str::uuid();

            $attempts++;
        } while ($this->uuidExists($uuid, $uuidField));

        return $uuid;
    }

    protected function uuidExists(string $uuid, string $field): bool
    {
        return static::where($field, $uuid)->exists();
    }

    public function getUuidField(): string
    {
        return $this->uuidField ?? 'uuid';
    }

    public function getUuidVersion(): int
    {
        return $this->uuidVersion ?? 4;
    }

    public function getUuidMaxAttempts(): int
    {
        return $this->uuidMaxAttempts ?? 5;
    }

    public function scopeWhereUuid(Builder $query, string $uuid): Builder
    {
        return $query->where($this->getUuidField(), $uuid);
    }

    public function scopeWhereUuidIn(Builder $query, array $uuids): Builder
    {
        return $query->whereIn($this->getUuidField(), $uuids);
    }

    public function getRouteKeyName(): string
    {
        return $this->getUuidField();
    }
}
