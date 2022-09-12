<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
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

        DB::table('template')->truncate();

        $dataArr = array(
            array('template_id' => '1', 'title' => 'Home Template', 'slug' => 'home', 'descp' => 'Used for home page only.', 'c_order' => '0', 'status' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('template_id' => '2', 'title' => 'Error / 404 Template', 'slug' => 'error-404', 'descp' => 'Used for error / 404 page only.', 'c_order' => '0', 'status' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('template_id' => '3', 'title' => 'Default Template', 'slug' => 'page', 'descp' => 'Used for cms pages only.', 'c_order' => '0', 'status' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('template_id' => '4', 'title' => 'About Template', 'slug' => 'about', 'descp' => 'Used for about page only.', 'c_order' => '0', 'status' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('template_id' => '5', 'title' => 'Contact Template', 'slug' => 'contact', 'descp' => 'Used for contact page only.', 'c_order' => '0', 'status' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('template_id' => '6', 'title' => 'Thank You Template', 'slug' => 'thank-you', 'descp' => 'Used for thank you page only.', 'c_order' => '0', 'status' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now())
        );

        DB::table('template')->insert($dataArr);
        $this->command->info('template table seeded!');
    }
}
