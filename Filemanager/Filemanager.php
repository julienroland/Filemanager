<?php  namespace Modules\Filemanager\Filemanager;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem as Filesystem;
use Illuminate\Config\Repository as Configuration;
use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\Factory as Flysystem;
use Modules\Filemanager\Filemanager\Image\Image;
use Modules\Filemanager\Http\Requests\UploadRequest;


/**
 * @property mixed setFileFullPath
 */
class FileManager extends AbstractFileManager
{
    public function __construct(
        Flysystem $flysystem,
        Filesystem $filesystem,
        Image $image,
        Carbon $date,
        Str $string,
        Configuration $config
    ) {
        $this->flysystem = $flysystem;
        $this->filesystem = $filesystem;
        $this->image = $image;
        $this->date = $date;
        $this->string = $string;
        $this->configuration = $config;
    }

    public function make($fileOrRequest, $type = null, $params = null)
    {
        if (!$this->isRequestAndSetFile($fileOrRequest)) {
            $this->setFile($fileOrRequest);
            $this->setFileType($type);
        }
        $this->setParams($params);
        $this->changeToTypeFile();
        $this->hasAProvider();
        return $this;
    }

    public function save()
    {
        $this->setSlug();
        $this->setFileFullPath();
        $fileUploaded = $this->fileSaveInFolder();
        $filedatabased = $this->fileSaveToDatabase($this->variant);
        if (!$this->getVariant()) {
            $this->file->id = $filedatabased->id;

        }
        if ($fileUploaded) {
            echo 'Uploaded';
        }
        if ($filedatabased) {
            return $filedatabased;
        }
    }

    public function variant($variants)
    {
        $this->setFileFullPath();

        if (!$this->getVariant()) {
            $this->save();
        }
        $this->variant = true;
        foreach ($variants as $key => $variant) {
            $this->{$key}($variant);
        }
        $this->file = $this->image->variants($this->file, $variants);
        dd($this);
        return $this;
    }

    public function resize($options)
    {
        $this->setImage($this->image->resize($this->file, $options));
        $this->setVariantName($options);
        $this->setVariantPrefix($this->file,
            $this->getVariantPrefixName('resize', $this->outputImgSize($options)));
        return $this;
    }

    protected function convertToImage($file = null)
    {
        if (is_null($file)) {
            $file = $this->getFile();
        }
        $type = $this->file->type;
        $params = $this->file->params;
        $this->file = $this->image->make($file);
        $this->file->type = $type;
        $this->file->params = $params;
        $this->file->name = $file->getClientOriginalName();
        $this->setFileSize($file);
        $this->file->extension = $file->getClientOriginalExtension();

        return $this->file;
    }

    private function isRequestAndSetFile($fileOrRequest)
    {
        if ($fileOrRequest instanceof UploadRequest) {

            if ($fileOrRequest->hasFile($this->configuration->get('filemanager::config.file_name'))) {
                $file = $fileOrRequest->file($this->configuration->get('filemanager::config.file_name'));
                $this->setFile($file);

                if ($fileOrRequest->has($this->configuration->get('filemanager::config.hidden_field_name'))) {

                    $this->setFileType($fileOrRequest->get($this->configuration->get('filemanager::config.hidden_field_name')));
                }

                return true;
            }

            return false;
        }

        return false;
    }

    private function changeToTypeFile()
    {
        $this->hasAProvider();
        switch ($this->file->type) {
            case 'file':
                return $this->detectFileType();
                break;
            case 'image':
                return $this->convertToImage();
                break;
        }
    }

    private function detectFileType()
    {
        //Todo: new class to check based on controller
    }


    private function fileSaveInFolder()
    {
        switch ($this->file->type) {
            case 'file':
                dd('save file');
                break;
            case 'image':
                return $this->image->save($this->file, $this->getPath(), 'directory', $this->provider);
                break;
        }
    }


    private function fileSaveToDatabase($variant = false)
    {
        switch ($this->file->type) {
            case 'file':
                dd('save file');
                break;
            case 'image':
                return $this->image->save($this->file, $this->getPath(), 'database', $variant, $this->provider);
                break;
        }
    }

    private function setFileFolders()
    {
        $this->file->folders = $this->getFileFolders();
    }


    private function getFilePathWithProvider($path, $provider)
    {
        $pathExplode = explode($path['path'], $path['pathfilename']);
        return $path['path'] . $provider . '/' . $pathExplode[1];
    }

    private function setVariantPrefix($file, $variant)
    {
        $file->slug = $this->addBeforeExtension($variant, $file->slug, $this->file->extension);
        $file->name = $this->addBeforeExtension($variant, $file->name, $this->file->extension);
    }

    private function addBeforeExtension($variant, $name, $extension)
    {
        $name = $this->getNameWithoutExtension($name);
        return $name . '-' . $variant . '.' . $extension;
    }

    private function getVariantPrefixName($string, $options)
    {
        return $string . '-' . $options;
    }

    private function outputImgSize($options)
    {
        return $options['width'] . 'x' . $options['height'];
    }

    private function setVariantName($options)
    {
        if (isset($options['name'])) {
            $this->file->variantName = $options['name'];
        } else {
            $this->file->variantName = null;
        }
    }

    private function setParams($params = null)
    {
        $this->file->params = $params;
    }

    private function getVariant()
    {
        return $this->variant;
    }


}
