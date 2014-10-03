<?php namespace Modules\Filemanager\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\Filemanager\Filemanager\FileUpload;
use Carbon\Carbon;
use Illuminate\Config\Repository as Configuration;
use Modules\Filemanager\Entities\File as FileModel;
use Intervention\Image\ImageManager;
use League\Flysystem\File;
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
        $this->app->bind('fileupload', function () {
            return new FileUpload(new File , new FileModel, new ImageManager, new Carbon, new Str);
        });

        AliasLoader::getInstance()->alias('Upload', 'Modules\Filemanager\Facades\FileUpload');

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
            'Modules\Filemanager\Repositories\FileUploadControllerRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileUploadControllerRepository'
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileRepository',
            'Modules\Filemanager\Repositories\Eloquent\EloquentFileRepository'
        );
    }
}
