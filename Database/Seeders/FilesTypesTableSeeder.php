<?php namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FileType;
use Pingpong\Modules\Facades\Module;

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
                'icon' => Module::asset('filemanager', 'images/image_icon.png'),
            ],
            [
                'name' => 'pdf',
                'context' => null,
                'icon' => Module::asset('filemanager', 'images/pdf_icon.png'),
            ],

        ];
        foreach ($data as $fileType) {

            FileType::create($fileType);
        }

    }

}