<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Filemanager\Entities\FileDirectory;
use Modules\Filemanager\Repositories\FileDirectoryRepository;

class EloquentFileDirectoryRepository implements FileDirectoryRepository
{
    public function all()
    {
        $folders = FileDirectory::all();
        return $folders;
    }

    public function create($name = null)
    {
        $folder = FileDirectory::create([
            'name' => $name
        ]);

        return $folder;
    }

    public function update($id, $request)
    {
        $folder = FileDirectory::find($id);
        $folder->name = $request->get('name');
        $folder->save();

        return $folder;

    }
}