<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class DiscoverTranslatableModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:discover-models {--path=app/Models : The path to scan for models}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover models that use HasTranslations trait and queue translations for untranslated records';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->option('path');
        $models = $this->discoverModels($path);

        if (empty($models)) {
            $this->warn("No translatable models found in {$path}.");
            return 0;
        }

        $this->info("Discovered " . count($models) . " translatable models:");

        foreach ($models as $model) {
            $this->line("  - {$model}");
        }

        /*if (!$this->confirm('Do you want to queue translations for all these models?')) {
            $this->info('Operation cancelled.');
            return 0;
        }*/

        $this->info('Processing models...');

        foreach ($models as $model) {
            $this->line("Processing {$model}...");

            $this->call('translate:find-untranslated', [
                'model' => $model
            ]);
        }

        $this->info('All models processed successfully!');

        return 0;
    }

    /**
     * Discover models that use the HasTranslations trait.
     *
     * @param  string  $path
     * @return array
     */
    protected function discoverModels($path)
    {
        $models = [];

        if (!$this->files->exists($path)) {
            return $models;
        }

        $files = $this->files->allFiles($path);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $className = $this->getClassNameFromFile($file);

            if (!$className) {
                continue;
            }

            if ($this->modelUsesTranslationsTrait($className)) {
                $models[] = $className;
            }
        }

        return $models;
    }

    /**
     * Get the fully qualified class name from a file.
     *
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @return string|null
     */
    protected function getClassNameFromFile(SplFileInfo $file)
    {
        $content = $this->files->get($file->getRealPath());

        // Extract namespace
        if (preg_match('/namespace\s+(.+);/', $content, $matches)) {
            $namespace = $matches[1];
        } else {
            $namespace = 'App';
        }

        // Extract class name
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $className = $matches[1];
            return $namespace . '\\' . $className;
        }

        return null;
    }

    /**
     * Check if a model uses the HasTranslations trait.
     *
     * @param  string  $className
     * @return bool
     */
    protected function modelUsesTranslationsTrait($className)
    {
        if (!class_exists($className)) {
            return false;
        }

        $reflection = new \ReflectionClass($className);

        return in_array('App\Traits\HasTranslations', $this->getClassTraits($reflection));
    }

    /**
     * Get all traits used by a class and its parents.
     *
     * @param  \ReflectionClass  $reflection
     * @return array
     */
    protected function getClassTraits(\ReflectionClass $reflection)
    {
        $traits = [];

        while ($reflection) {
            $traits = array_merge($traits, $reflection->getTraitNames());
            $reflection = $reflection->getParentClass();
        }

        return array_unique($traits);
    }
}
