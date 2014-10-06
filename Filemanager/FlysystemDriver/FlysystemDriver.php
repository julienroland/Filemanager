<?php namespace Modules\Filemanager\Filemanager\FlysystemDriver;

use Dropbox\Client;
use League\Flysystem\Filesystem as Flysystem;
use Illuminate\Filesystem\FilesystemManager;
use League\Flysystem\Adapter\Dropbox as DropboxAdapter;

class FlysystemDriver extends FilesystemManager
{
    /**
     * Create an instance of the given driver.
     *
     * @param  array $config
     * @return \Illuminate\Contracts\Filesystem\Cloud
     */
    public function createDropboxDriver(array $config)
    {
        $client = new Client($config['token'], $config['app']);
        return $this->adapt(new Flysystem(
            new DropboxAdapter($client)
        ));
        //return $this->decorate(new Flysystem(new DropboxAdapter($client)));
    }

    /**
     * Get the filesystem connection configuration.
     *
     * @param  string $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["filemanager::config.{$name}"];
        //return $this->app['config']["filesystems.disks.{$name}"];

    }

}