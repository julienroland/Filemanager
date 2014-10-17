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
                'name' => 'Icon',
                'slug' => 'icon',
                'description' => 'Icones de la bibliothèque d\'image',
                'value' => '{"width":"60","height":"60","aspect":false}',
                'prefix' => '-icon',
            ],

        ];

        foreach ($data as $variantType) {

            FileVariantType::create($variantType);
        }
    }

}