<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Filemanager\Entities\FileDirectory;
use Modules\Filemanager\Repositories\FileDirectoryRepository;

class EloquentFileDirectoryRepository implements FileDirectoryRepository
{
    public function find($id)
    {
        return FileDirectory::find($id);
    }

    public function get($id = null)
    {
        $folders = FileDirectory::where('parent_id', $id)->get();
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

    public function append($folder1_id, $folder2_id = null)
    {
        $folder = FileDirectory::find($folder1_id);
        $folder->parent_id = $folder2_id;
        $folder->save();

        return $folder;
    }
}