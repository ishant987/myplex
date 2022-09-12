<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     if (App::environment(['production'])) 
     {
        print "\nOpps! you are in production environment. You are not authorized to run.\n";
        die();
    }

    DB::table('admin')->truncate();

    $dataArr = array(
      array('admin_id' => '1','role_id' => '1','username' => 'admin','password' => Hash::make('admin123$'),'display_name' => 'Administrator','first_name' => 'Vikash','last_name' => 'Kumar','email' => 'vikash@showtimemedia.in','website' => '','status' => '1','email_verified_at' => NULL,'remember_token' => 'SsskuyYt7SdNMRzLO5dKs0mxPyDJV6orfDGjw8uugLEvXd6oAFf6l5Yys5zS','updated_id' => '1','created_at' => '2020-10-24 13:01:27','updated_at' => '2020-12-18 11:18:49')
  );

    DB::table('admin')->insert( $dataArr );
    $this->command->info('admin table seeded!');

}
}
