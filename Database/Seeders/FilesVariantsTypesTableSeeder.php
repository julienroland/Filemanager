<?php namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FileVariantType;

class FilesVariantsTypesTableSeeder extends Seeder
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
                'name' => 'Resize',
                'slug' => 'resize',
                'value' => '{"width":"300","height":"300","aspect":true}',
                'prefix' => '-resize',
            ],
            [
                'name' => 'Crop',
                'slug' => 'crop',
                'value' => '{"width":"300","height":"300","x":"0","y":"0"}',
                'prefix' => '-crop',
            ],
            [
                'name' => 'Avatar',
                'slug' => 'avatar',
                'value' => '{"width":"90","height":"90"}',
                'prefix' => '-avatar',
            ],
            [
                'name' => 'Greyscale',
                'slug' => 'greyscale',
                'value' => null,
                'prefix' => '-greyscale',
            ],
            [
                'name' => 'Saturation',
                'slug' => 'saturation',
                'value' => '{"level":0}',
                'prefix' => '-saturation',
            ],
            [
                'name' => 'Blur',
                'slug' => 'blur',
                'value' => '{"amount":50}',
                'prefix' => '-blur',
            ],
            [
                'name' => 'Circle',
                'slug' => 'circle',
                'value' => '{"radius":"300","x":"200","y":"#FF000"}',
                'prefix' => '-circle',
            ]
        ];

        foreach ($data as $variantType) {

            FileVariantType::create($variantType);
        }
    }

}