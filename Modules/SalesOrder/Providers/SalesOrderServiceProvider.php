<?php

namespace Modules\SalesOrder\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\SalesOrder\Models\SalesOrder;
use Modules\SalesOrder\Observers\SalesOrderObserver;
use Modules\SalesOrder\Repositories\Contracts\SalesOrderRepository;
use Modules\SalesOrder\Repositories\SalesOrderRepositoryEloquent;

class SalesOrderServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'SalesOrder';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'salesorder';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        SalesOrder::observe(SalesOrderObserver::class);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(SalesOrderRepository::class, function () {
            return new SalesOrderRepositoryEloquent(new SalesOrder());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}
