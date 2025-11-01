<?php

namespace App\Console\Commands\Modules;

use App\Services\ModuleLoader;
use Illuminate\Console\Command;

class DeleteModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a module completely';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $moduleName = $this->argument('name');
        $result = ModuleLoader::deleteModule($moduleName);
        $this->info($result);
    }
}
