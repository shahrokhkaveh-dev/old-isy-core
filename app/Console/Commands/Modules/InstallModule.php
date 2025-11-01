<?php

namespace App\Console\Commands\Modules;

use App\Services\ModuleLoader;
use Illuminate\Console\Command;

class InstallModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:install {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install a module';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $moduleName = $this->argument('name');
        $result = ModuleLoader::installModules($moduleName);
        $this->info($result);
    }
}
