<?php namespace Modules\Filemanager\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Filemanager\Filemanager\Filemanager;


class FilemanagerServiceProvider extends ServiceProvider
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
        $this->app->bind('filemanager', function () {
            return new Filemanager;
        });

        AliasLoader::getInstance()->alias('Filemanager', 'Modules\Filemanager\Facades\Filemanager');

        $this->app->booted(function () {
            $this->registerBindings();
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

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Filemanager\Repositories\FilemanagerControllerRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFilemanagerControllerRepository'
        );
    }
}
