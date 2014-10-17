<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\File;
use Modules\Filemanager\Entities\FileDirectory;
use Modules\Filemanager\Repositories\FileRepository;

class EloquentFileRepository implements FileRepository
{

    public function find($file_id)
    {
        return File::whereId($file_id)->with([
            'fileDirectory',
            'fileVariant' => function ($query) {
                $query->icon();
            }
        ])->first();
    }

    public function create($file)
    {
        $file = File::create($file);
        $file->fileDirectory()->attach(['file_directory_id' => null]);
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

    public function append($file_id, $folder_id)
    {
        $dir = FileDirectory::find($folder_id);
        $file = File::find($file_id);

        $file->fileDirectory()->detach();
        $res = $dir->file()->attach($file);

        return $res;
    }

    public function getByDirectories($id = null)
    {
        $file = File::with([
            /*'fileDirectory' => function ($query) use($id){
                $query->where('file_directory_id', $id);
            },*/
            'fileVariant' => function ($query) {
                $query->icon();
            }
        ]);
        if (!is_null($id)) {
            $file = $file->whereHas('fileDirectory', function ($query) use ($id) {
                $query->where('file_directory_id', $id);
            });
        }else{
            $file = $file->has('fileDirectory','=',0);
        }
        return $file->get();
    }
}