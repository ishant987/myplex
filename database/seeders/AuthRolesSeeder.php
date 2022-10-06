<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AuthRolesSeeder extends Seeder
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

		DB::table('auth_roles')->truncate();

		$dataArr = array(
			array('role_id' => '1', 'title' => 'Super Administrator', 'created_at' => now(), 'updated_id' => '1', 'updated_at' => now())
		);

		DB::table('auth_roles')->insert($dataArr);
		$this->command->info('auth_roles table seeded!');
	}
}
