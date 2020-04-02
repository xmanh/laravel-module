<?php

namespace XManh\Module\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Modules';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModules();
    }

    /**
     * register modules
     *
     * @return void
     */
    protected function registerModules()
    {
        $path = app_path('Modules');

        if (File::exists($path)) {
            $modules = array_map('basename', File::directories($path));

            foreach ($modules as $module) {
                $this->loadModuleRoutes($module);
                $this->loadModuleMigrations($module);
                $this->loadModuleTranslations($module);
                $this->loadModuleViews($module);
            }
        }
    }

    protected function loadModuleRoutes($module)
    {
        $path = app_path('Modules/' . $module . '/routes.php');
        if (File::exists($path)) {
            $this->loadRoutesFrom($path);
        }
    }

    protected function loadModuleMigrations($module)
    {
        $path = app_path('Modules/' . $module . '/Migrations');
        if (File::exists($path)) {
            $this->loadMigrationsFrom($path);
        }
    }

    protected function loadModuleTranslations($module)
    {
        $path = app_path('Modules/' . $module . '/Languages');
        if (File::exists($path)) {
            $this->loadTranslationsFrom($path, $module);
        }
    }

    protected function loadModuleViews($module)
    {
        $path = app_path('Modules/' . $module . '/Views');
        if (File::exists($path)) {
            $this->loadViewsFrom($path, $module);
        }
    }
}
