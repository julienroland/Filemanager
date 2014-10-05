<?php  namespace Modules\Filemanager\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Filemanager\Filemanager\FlysystemDriver\FlysystemDriver;

class FlysystemDriverServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booted(function ($app) {
            $this->registerBindings($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }


    private function registerBindings($app)
    {
        // $this->app->bind('flysystemdriver', function () use ($app) {
        //   return new FlysystemDriver($app['config']);
        // });

        $this->app->bind(
            'Illuminate\Contracts\Filesystem\Factory', function ($app) {
                return new FlysystemDriver($app);
                });

    }


}
