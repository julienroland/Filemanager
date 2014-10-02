<?php namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FilemanagerDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call("Modules\\Filemanager\\Database\\Seeders\\FilesVariantsTypesTableSeeder");
        $this->call("Modules\\Filemanager\\Database\\Seeders\\FilesTypesTableSeeder");
        $this->call("Modules\\Filemanager\\Database\\Seeders\\FilesAccessTypesTableSeeder");
        $this->call("Modules\\Filemanager\\Database\\Seeders\\FilesPathsTableSeeder");

	}

}