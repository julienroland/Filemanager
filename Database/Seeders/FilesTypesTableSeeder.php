<?php namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FileType;

class FilesTypesTableSeeder extends Seeder
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
                'name' => 'image',
                'context' => null,
            ],
            [
                'name' => 'pdf',
                'context' => null,
            ],
        ];
        foreach ($data as $fileType) {

            FileType::create($fileType);
        }

    }

}