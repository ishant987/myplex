<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment(['production'])) {
			print "\nOpps! you are in production environment. You are not authorized to run.\n";
			die();
		}

		DB::table('menu_type')->truncate();

		$dataArr = array(
            array('menu_type_id' => '1','label' => 'Primary','menu_name' => 'primary_menu','menu_for' => 'p','c_order' => '0','status' => '1','created_id' => '1','updated_id' => '1','created_at' => now(),'updated_at' => now())
		);

		DB::table('menu_type')->insert($dataArr);
		$this->command->info('menu_type table seeded!');
    }
}
