<?php namespace Modules\Filemanager\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Modules\Filemanager\Filemanager\Form\OutputFileForm;
use Modules\Filemanager\Filemanager\TemplateFileUpload;

class FilemanagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The filters base class name.
     *
     * @var array
     */
    protected $filters = [
        'Core' => [
            'permissions' => 'PermissionFilter'
        ]
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booted(function ($app) {
            $this->registerFilters($app['router']);
            $this->bindFacade($app);
            $this->registerBindings();

            AliasLoader::getInstance()->alias('Upload', 'Modules\Filemanager\Facades\TemplateFileUpload');
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

    /**
     * @param Router $router
     */
    public function registerFilters(Router $router)
    {
        foreach ($this->filters as $module => $filters) {
            foreach ($filters as $name => $filter) {
                $class = "Modules\\{$module}\\Http\\Filters\\{$filter}";

                $router->filter($name, $class);
            }
        }
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileUploadControllerRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileUploadControllerRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileTypeRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileTypeRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileVariantRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileVariantRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileDirectoryRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileDirectoryRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileAccessTypeRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileAccessTypeRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\ThumbControllerRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentThumbControllerRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\ImageManipulationRepository',
            'Modules\Filemanager\Repositories\ImageIntervention\ImageInterventionImageManipulationRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\ImageManagerRepository',
            'Modules\Filemanager\Repositories\ImageIntervention\ImageInterventionImageManagerRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FilesystemRepository',
            'Modules\Filemanager\Repositories\Illuminate\IlluminateFilesystemRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\ThumbRepository',
            'Modules\Filemanager\Repositories\File\FileThumbRepository'
        );
    }

    private function bindFacade($app)
    {
        $this->app->bind('templatefileupload', function () use ($app) {
            return new TemplateFileUpload(
                new OutputFileForm($app['config'])
            );
        });
    }
}
