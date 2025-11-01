<?php

namespace App\Console\Commands\Modules;

use App\Services\ModuleLoader;
use Illuminate\Console\Command;

class UninstallModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:uninstall {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall a module';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $moduleName = $this->argument('name');
        $result = ModuleLoader::uninstallModules($moduleName);
        $this->info($result);
    }
}
