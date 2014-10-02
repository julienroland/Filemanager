<?php namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FilePath;

class FilesPathsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            [
                "local_path" => "filemanager",
                "external_path" => null,
            ]
        ];
        foreach ($data as $filePath) {

            FilePath::create($filePath);

        }
    }

}