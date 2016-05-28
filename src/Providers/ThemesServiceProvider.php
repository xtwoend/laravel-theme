<?php

namespace Xtwoend\Themes\Providers;

use Xtwoend\Themes\Repository;
use Xtwoend\Themes\Finder\Finder;
use Illuminate\Support\ServiceProvider;
use Xtwoend\Themes\View\ThemeFileViewFinder;

class ThemesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->registerConfig();

        $this->registerNamespaces();

        $this->registerHelpers();

        $this->app['themes']->set(config('themes.default'));
        
    }

    /**
     * Register the helpers file.
     */
    public function registerHelpers()
    {
        require __DIR__.'/../../helpers/helper.php';
    }

    /**
     * Register configuration file.
     */
    protected function registerConfig()
    {
        $configPath = __DIR__.'/../../config/themes.php';

        $this->publishes([$configPath => config_path('themes.php')]);

        $this->mergeConfigFrom($configPath, 'themes');
    }

    /**
     * Register the themes namespaces.
     */
    protected function registerNamespaces()
    {
        $this->app['themes']->registerNamespaces();
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            $paths = $app['config']['view.paths'];
            return new ThemeFileViewFinder($app['files'], $paths);
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app['themes'] = $this->app->share(function ($app) {
            return new Repository(
                new Finder(),
                $app['config'],
                $app['view'],
                $app['translator'],
                $app['cache.store']
            );
        });

        $this->registerCommands();
        $this->registerViewFinder();
    }

    /**
     * Register commands.
     */
    protected function registerCommands()
    {
        $this->commands('Xtwoend\Themes\Console\MakeCommand');
        $this->commands('Xtwoend\Themes\Console\CacheCommand');
        $this->commands('Xtwoend\Themes\Console\ListCommand');
        $this->commands('Xtwoend\Themes\Console\PublishCommand');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('themes');
    }
}
