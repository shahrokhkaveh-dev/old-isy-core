<?php

namespace App\Console\Commands;

use App\Jobs\TranslateModelFields;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class TranslateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:model
                           {model : Full model class (e.g. App\Models\User)}
                           {id : Record ID}
                           {source=fa-IR : Source language}
                           {target=en-US : Target language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate translatable fields of a specific model record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelClass = $this->argument('model');
        $id = $this->argument('id');
        $source = $this->argument('source');
        $target = $this->argument('target');

        // Check if model class exists
        if (!class_exists($modelClass)) {
            $this->error("Model {$modelClass} not found!");
            return 1;
        }

        // Check if class is an Eloquent model
        if (!is_subclass_of($modelClass, Model::class)) {
            $this->error("Class {$modelClass} is not a valid Eloquent model!");
            return 1;
        }

        // Find the model record
        $model = $modelClass::find($id);
        if (!$model) {
            $this->error("Record with ID {$id} not found in model {$modelClass}!");
            return 1;
        }

        // Check if model uses HasTranslations trait
        if (!in_array('App\Traits\HasTranslations', class_uses_recursive($modelClass))) {
            $this->error("Model {$modelClass} does not use HasTranslations trait!");
            return 1;
        }

        // Check if model has translatable fields
        if (empty($model->getTranslatableAttributes())) {
            $this->error("Model {$modelClass} has no translatable fields!");
            return 1;
        }

        // Display information before execution
        $this->info("Preparing translation for:");
        $this->line("  Model: {$modelClass}");
        $this->line("  ID: {$id}");
        $this->line("  Source language: {$source}");
        $this->line("  Target language: {$target}");
        $this->line("  Translatable fields: " . implode(', ', $model->getTranslatableAttributes()));

        // Dispatch translation job to queue
        TranslateModelFields::dispatch($model, $source, $target);
            //->onQueue('translations');

        $this->info("Translation job successfully queued!");
        $this->info("Use `php artisan queue:work` to process the job.");
        //$this->info("Use `php artisan queue:work --queue=translations` to process the job.");

        return Command::SUCCESS;
    }
}
