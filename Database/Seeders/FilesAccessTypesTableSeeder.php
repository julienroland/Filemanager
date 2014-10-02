<?php namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FileAccessType;

class FilesAccessTypesTableSeeder extends Seeder
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
                "name" => "local",
            ],
            [
                "name" => "http",
            ],
            [
                "name" => "ftp",
            ]
        ];
        foreach ($data as $fileAccessType) {

            FileAccessType::create($fileAccessType);

        }
    }

}