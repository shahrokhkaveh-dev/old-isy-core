<?php
namespace App\Traits;

use App\Jobs\TranslateModelFields;
use App\Jobs\UpdateModelTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait HasTranslations
{
    // protected array $translatable = [];
    // protected string $translationModel = '';
    // protected string $translationForeignKey = '';
    protected array $traitHidden = ['translation', 'translations'];

    /**
     * Boot the trait
     */
    public static function bootHasTranslations(): void
    {
        static::created(function ($model) {
            $model->queueTranslationForNewFields();
        });

        static::updated(function ($model) {
            $model->queueTranslationForUpdatedFields();
        });
    }

    /**
     * Queue translation jobs for new translatable fields
     */
    protected function queueTranslationForNewFields(): void
    {
        $translatableFields = $this->getTranslatableAttributes();

        if (empty($translatableFields)) {
            return;
        }

        // Get configuration settings
        $sourceLanguage = config('translation.source_language', 'fa-IR');
        $targetLanguages = config('translation.target_languages', ['en-US']);

        foreach ($targetLanguages as $targetLanguage) {
            // Check if translation exists for this record and target language
            $exists = $this->translations()
                ->where($this->getTranslationLangKey(), $targetLanguage)
                ->exists();

            if (!$exists) {
                // Dispatch translation job
                TranslateModelFields::dispatch($this, $sourceLanguage, $targetLanguage)
                    ->onQueue('translations');
            }
        }
    }

    /**
     * Queue translation jobs for updated translatable fields
     */
    protected function queueTranslationForUpdatedFields(): void
    {
        $translatableFields = $this->getTranslatableAttributes();
        $changedFields = $this->getDirty();

        if (empty($translatableFields) || empty($changedFields)) {
            return;
        }

        // Check if any translatable field was changed
        $updatedTranslatableFields = array_intersect_key($changedFields, array_flip($translatableFields));

        if (empty($updatedTranslatableFields)) {
            return;
        }

        // Get configuration settings
        $sourceLanguage = config('translation.source_language', 'fa-IR');

        // Dispatch update translation job
        UpdateModelTranslations::dispatch($this, $updatedTranslatableFields, $sourceLanguage)
            ->onQueue('translations');
    }

    /**
     * Current translation relationship (based on system language)
     */
    public function translation(): HasOne
    {
        $searchLang = $this->getTranslationLang();

        $searchOp = "like";
        $searchValue = "{$searchLang}-%";

        if(Str::contains($searchLang, "-")) {
            $searchOp = "=";
            $searchValue = $searchLang;
        }

        return $this->hasOne($this->getTranslationModel(), $this->getTranslationForeignKey())
            ->where($this->getTranslationLangKey(), $searchOp, $searchValue);
    }

    /**
     * All translations relationship
     */
    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationModel(), $this->getTranslationForeignKey());
    }

    /**
     * Get the translation model name
     */
    public function getTranslationModel(): string
    {
        return $this->translationModel ?? get_class($this) . 'Translate';
    }

    /**
     * Get the foreign key for translations
     */
    public function getTranslationForeignKey(): string
    {
        return $this->translationForeignKey ?? Str::snake(class_basename($this)) . '_id';
    }

    /**
     * Get the language key in the translation model
     */
    public function getTranslationLangKey(): string
    {
        return $this->translationLangKey ?? 'locale';
    }

    /**
     * Get the current language
     */
    public function getTranslationLang(): string
    {
        return $this->TranslationLang ?? app()->getLocale();
    }

    /**
     * get translatable attributes
     */
    public function getTranslatableAttributes(): array
    {
        return $this->translatable ?? [];
    }

    /**
     * Add translation fields to $appends
     */
    public function initializeHasTranslations()
    {
        // Add translatable fields to $appends
        $this->appends = array_unique(array_merge($this->appends, $this->translatable));
    }

    /**
     * Get the translated field value
     */
    protected function getTranslationValue(string $field)
    {
        // Loads the relationship if it's not already loaded
        if (!$this->relationLoaded('translation')) {
            $this->load('translation');
        }
        return $this->translation?->{$field} ?? $this->getOriginal($field);
    }

    /**
     * Scope for searching based on translated field
     */
    public function scopeWhereTranslation(Builder $query, string $field, $value, string $operator = '=', ?string $locale = null): Builder
    {
        $locale = $locale ?? app()->getLocale();
        return $query->whereHas('translations',
            fn ($q) => $q->where($field, $operator, $value)->where($this->getTranslationLangKey(), $locale)
        );
    }

    /**
     * Scope for sorting based on translated field
     */
    public function scopeOrderByTranslation(Builder $query, string $field, string $direction = 'asc', ?string $locale = null): Builder
    {
        $locale = $locale ?? $this->getTranslationLang();
        $translationModel = $this->getTranslationModel();
        $foreignKey = $this->getTranslationForeignKey();
        $langKey = $this->getTranslationLangKey();
        $table = $this->getTable();
        $keyName = $this->getKeyName();

        return $query->orderBy(
            $translationModel::select($field)
                ->whereColumn($foreignKey, "$table.$keyName")
                ->where($langKey, $locale)
                ->latest()
                ->take(1),
            $direction
        );
    }

    /**
     * Show translation relationships in output
     */
    public function withTranslationRelations()
    {
        return $this->makeVisible(['translation', 'translations']);
    }

    /**
     * Get attributes that should be hidden in array and JSON
     */
    public function getHidden(): array
    {
        return array_merge(
            parent::getHidden(),
            $this->traitHidden
        );
    }

    /**
    * Scope to only include records that have a translation for the current locale
    */
    public function scopeWhereHasTranslation(Builder $query, ?string $locale = null): Builder
    {
        $locale = $locale ?? $this->getTranslationLang();
        return $query->whereHas('translations', function ($query) use ($locale) {
            $query->where($this->getTranslationLangKey(), $locale);
        });
    }
    /**
     * Create dynamic accessors for translation fields
     */
    public function __call($method, $parameters)
    {
        // Check if the method is an accessor for a translation field
        if (preg_match('/^get(.+)Attribute$/', $method, $matches)) {
            $field = Str::snake($matches[1]);
            // If the field is in the list of translatable fields
            if (in_array($field, $this->translatable)) {
                return $this->getTranslationValue($field);
            }
        }
        return parent::__call($method, $parameters);
    }
}
