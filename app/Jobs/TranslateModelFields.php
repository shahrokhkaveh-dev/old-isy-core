<?php

namespace App\Jobs;

use App\Traits\HasTranslations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Lib\Translator\Facades\GoogleTranslate as Translator;

class TranslateModelFields implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Model $model
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @return void
     */
    public function __construct(protected Model $model, protected string $sourceLanguage, protected string $targetLanguage)
    {
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

        // Prepare translation data
        $translationData = [
            $this->model->getTranslationForeignKey() => $this->model->getKey(),
            'locale' => $this->targetLanguage,
        ];

        // Translate each field
        foreach ($translatableFields as $field) {
            $originalValue = $this->model->getAttribute($field);

            // Skip if empty
            if (empty($originalValue)) {
                continue;
            }

            if ($this->sourceLanguage === $this->targetLanguage) {
                $translationData[$field] = $originalValue;
                continue;
            }

            // Translate the field
            $translationResult = Translator::translate(
                $originalValue,
                $this->sourceLanguage,
                $this->targetLanguage
            );

            // Add translated text to translation data
            $translationData[$field] = $translationResult->getTranslatedText();
        }

        // Create translation record
        $translationModel = $this->model->getTranslationModel();
        $translationModel::create($translationData);
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return [
            'translation',
            get_class($this->model) . ':' . $this->model->getKey(),
            'from:' . $this->sourceLanguage,
            'to:' . $this->targetLanguage,
        ];
    }
}
