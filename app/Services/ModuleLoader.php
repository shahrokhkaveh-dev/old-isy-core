<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModuleLoader
{
    protected static array $modules = [];

    public static function loadModules(): void
    {
        $modulesPath = app_path('Modules');
        if(!File::exists($modulesPath)){
            return;
        }
        $directories = File::directories($modulesPath);
        foreach ($directories as $directory) {
            $moduleName = basename($directory);
            $configPath = $directory . '/module.json';
            if (File::exists($configPath)) {
                $config = json_decode(File::get($configPath), true);
                if ($config && isset($config['status']) && $config['status'] === 'active') {
                    self::$modules[$moduleName] = $config;
                    self::registerServiceProvider($config);
                    self::registerRoutes($config, $moduleName);
                }
            }
        }
    }

    protected static function registerServiceProvider(array $config): void
    {
        if(!isset($config['providers'])) return;

        foreach ($config['providers'] as $provider) {
            app()->register($provider);
        }
    }

    protected static function registerRoutes(mixed $config, string $moduleName): void
    {
        if(!isset($config['routes'])) return;

        foreach ($config['routes'] as $routeType) {
            $routeFile = app_path("Modules/$moduleName/Routes/{$routeType}.php");
            if (File::exists($routeFile)) {
                match ($routeType) {
                    'api', 'web' => require $routeFile,
                    default => null,
                };
            }
        }
    }

    public static function installModules(string $moduleName): string
    {
        $modulesPath = app_path('Modules/'.$moduleName);
        if(!File::exists($modulesPath)){
            return "Module $moduleName not found";
        }

        $configPath = $modulesPath.'/module.json';
        if(!File::exists($configPath)){
            return "Module $moduleName not found";
        }

        $config = json_decode(File::get($configPath), true);
        if(!isset($config['status']) || $config['status'] === 'active'){
            return "Module $moduleName is active";
        }
        Artisan::call('migrate', ['--path' => "app/Modules/$moduleName/Database/Migrations",'--force' => true]);
        $config['status'] = 'active';
        File::put($configPath, json_encode($config, JSON_PRETTY_PRINT));

        return "Module $moduleName installed successfully";
    }

    public static function uninstallModules(string $moduleName): string
    {
        $modulesPath = app_path('Modules/'.$moduleName);
        if(!File::exists($modulesPath)){
            return "Module $moduleName not found";
        }

        $configPath = $modulesPath.'/module.json';
        if(!File::exists($configPath)){
            return "Module $moduleName not found";
        }

        $config = json_decode(File::get($configPath), true);
        if(!isset($config['status']) || $config['status'] !== 'active'){
            return "Module $moduleName not active";
        }
//        dd("app/Modules/$moduleName/Database/Migrations");
        Artisan::call('migrate:rollback', ['--path' => "app/Modules/$moduleName/Database/Migrations", '--force' => true]);
        $config['status'] = 'inactive';
        File::put($configPath, json_encode($config, JSON_PRETTY_PRINT));

        return "Module $moduleName uninstalled successfully";
    }

    public static function deleteModule(string $moduleName): string
    {
        $modulesPath = app_path('Modules/'.$moduleName);
        if(!File::exists($modulesPath)){
            return "Module $moduleName not found";
        }
        $uninstall = self::uninstallModules($moduleName);
        File::deleteDirectory($modulesPath);
        return "Module $moduleName deleted successfully";
    }
}
