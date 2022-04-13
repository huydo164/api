<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $modules = array_map('basename', File::directories(base_path('modules')));
        foreach ($modules as $module) {
            $modulePath = base_path('modules') . '/' . $module;

            $migrationPath = "{$modulePath}/migrations";
            if (is_dir($migrationPath)) {
                $this->loadMigrationsFrom($migrationPath);
            }

            $routePath = "{$modulePath}/routes";
            if (is_dir($routePath)) {
                $routeFile = "{$routePath}/api.php";
                if (file_exists($routeFile)) {
                    Route::prefix('api')
                        ->middleware('api')
                        ->namespace("Modules\\{$module}\\Controllers")
                        ->group($routeFile);
                }

                $routeFile = "{$routePath}/web.php";
                if (file_exists($routeFile)) {
                    Route::middleware('web')
                        ->namespace("Modules\\{$module}\\Controllers")
                        ->group($routeFile);
                }
            }
        }
    }
}
