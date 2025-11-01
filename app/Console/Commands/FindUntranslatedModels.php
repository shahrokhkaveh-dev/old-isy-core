<?php

namespace App\Console\Commands;

use App\Jobs\TranslateModelFields;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class FindUntranslatedModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:find-untranslated {model : The model class (e.g. App\Models\User)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find untranslated model records and dispatch translation jobs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $modelClass = $this->argument('model');

        // Validate model class
        if (!class_exists($modelClass)) {
            $this->error("Model class {$modelClass} does not exist.");
            return 1;
        }

        if (!is_subclass_of($modelClass, Model::class)) {
            $this->error("Class {$modelClass} is not an Eloquent model.");
            return 1;
        }

        // Get configuration settings
        $sourceLanguage = Config::get('translation.source_language', 'fa-IR');
        $targetLanguages = Config::get('translation.target_languages', ['en-US']);

        // Create model instance to access its methods
        $model = new $modelClass;

        // Check if model uses HasTranslations trait
        if (!in_array('App\Traits\HasTranslations', class_uses_recursive($modelClass))) {
            $this->error("Model {$modelClass} does not use the HasTranslations trait.");
            return 1;
        }

        // Get translation model and foreign key
        $translationModel = $model->getTranslationModel();
        $foreignKey = $model->getTranslationForeignKey();

        $this->info("Searching for untranslated records in {$modelClass}...");
        $this->line("Source language: {$sourceLanguage}");
        $this->line("Target languages: " . implode(', ', $targetLanguages));

        $jobCount = 0;

        // Process records in chunks to avoid memory issues
        $modelClass::chunk(100, function ($records) use ($targetLanguages, $translationModel, $foreignKey, $sourceLanguage, &$jobCount) {
            foreach ($records as $record) {
                foreach ($targetLanguages as $targetLanguage) {
                    // Check if translation exists for this record and target language
                    $exists = $translationModel::where($foreignKey, $record->id)
                        ->where('locale', $targetLanguage)
                        ->exists();

                    if (!$exists) {
                        // Dispatch translation job
                        TranslateModelFields::dispatch($record, $sourceLanguage, $targetLanguage)
                            ->onQueue('translations');

                        $jobCount++;
                        $this->line("Queued translation for record ID {$record->id} to {$targetLanguage}");
                    }
                }
            }
        });

        $this->info("Dispatched {$jobCount} translation jobs.");

        return 0;
    }
}
