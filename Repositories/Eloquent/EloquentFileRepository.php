<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\File;
use Modules\Filemanager\Entities\FileType;
use Modules\Filemanager\Repositories\FileRepository;

class EloquentFileRepository implements FileRepository
{

    public function create($file)
    {
        $file = File::create($file);

        return $file;

    }

    public function all()
    {
        $files = File::with('fileType')->get();

        return $files;
    }

    public function update($id, $request)
    {
        $file = File::find($id);
        $file->name = $request->get('name');
        $file->save();

        return $file;
    }
}