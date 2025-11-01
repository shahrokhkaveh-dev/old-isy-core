<?php

namespace App\Jobs;

use App\Traits\HasTranslations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Lib\Translator\Facades\GoogleTranslate as Translator;

class UpdateModelTranslations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Model $model
     * @param array $updatedFields
     * @param string $sourceLanguage
     * @return void
     */
    public function __construct(
        protected Model $model,
        protected array $updatedFields,
        protected string $sourceLanguage = 'fa-IR'
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ensure the model uses the HasTranslations trait
        if (!in_array(HasTranslations::class, class_uses_recursive($this->model))) {
            return;
        }

        // Get translatable fields
        $translatableFields = $this->model->getTranslatableAttributes();

        // Filter updated fields to only include translatable ones
        $updatedTranslatableFields = array_intersect_key($this->updatedFields, array_flip($translatableFields));

        if (empty($updatedTranslatableFields)) {
            return;
        }

        // Get all existing translations for this model
        $translations = $this->model->translations()->get();

        // Get target languages from config
        $targetLanguages = config('translation.target_languages', ['en-US']);

        foreach ($translations as $translation) {
            $targetLanguage = $translation->{$this->model->getTranslationLangKey()};

            // Skip if source and target languages are the same
            if ($this->sourceLanguage === $targetLanguage) {
                foreach ($updatedTranslatableFields as $field => $value) {
                    $translation->{$field} = $value;
                }
                $translation->save();
                continue;
            }

            // Update each translatable field
            foreach ($updatedTranslatableFields as $field => $value) {
                // Skip if empty
                if (empty($value)) {
                    continue;
                }

                // Translate the field
                $translationResult = Translator::translate(
                    $value,
                    $this->sourceLanguage,
                    $targetLanguage
                );

                // Update translated text
                $translation->{$field} = $translationResult->getTranslatedText();
            }

            $translation->save();
        }

        // Create translations for any missing target languages
        foreach ($targetLanguages as $targetLanguage) {
            $exists = $translations->contains(function ($translation) use ($targetLanguage) {
                return $translation->{$this->model->getTranslationLangKey()} === $targetLanguage;
            });

            if (!$exists) {
                // Dispatch translation job for missing language
                TranslateModelFields::dispatch($this->model, $this->sourceLanguage, $targetLanguage)
                    ->onQueue('translations');
            }
        }
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return [
            'translation:update',
            get_class($this->model) . ':' . $this->model->getKey(),
        ];
    }
}
