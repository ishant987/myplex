<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
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

        DB::table('pages')->truncate();

        $dataArr = array(
            array('page_id' => '1', 'title' => 'Home', 'slug' => 'home', 'descp' => '', 'media_id' => '0', 'parent' => '0', 'template_id' => '1', 'is_private' => '1', 'note' => '', 'meta_title' => '', 'meta_key' => '', 'meta_descp' => '', 'c_order' => '0', 'status' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('page_id' => '2', 'title' => 'Oops!', 'slug' => 'oops', 'descp' => '<p>The page you’re looking for could not be found.</p>', 'media_id' => '0', 'parent' => '0', 'template_id' => '2', 'is_private' => '1', 'note' => '', 'meta_title' => '', 'meta_key' => '', 'meta_descp' => '', 'c_order' => '0', 'status' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('page_id' => '3', 'title' => 'About Us', 'slug' => 'about-us', 'descp' => '', 'media_id' => '0', 'parent' => '0', 'template_id' => '4', 'is_private' => '1', 'note' => '', 'meta_title' => '', 'meta_key' => '', 'meta_descp' => '', 'c_order' => '0', 'status' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('page_id' => '4', 'title' => 'Contact Us', 'slug' => 'contact-us', 'descp' => '', 'media_id' => '0', 'parent' => '0', 'template_id' => '5', 'is_private' => '1', 'note' => '', 'meta_title' => '', 'meta_key' => '', 'meta_descp' => '', 'c_order' => '0', 'status' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('page_id' => '5', 'title' => 'Thank You', 'slug' => 'contact-enq', 'descp' => '<p>Your message has been sent.</p>', 'media_id' => '0', 'parent' => '0', 'template_id' => '6', 'is_private' => '1', 'note' => '', 'meta_title' => '', 'meta_key' => '', 'meta_descp' => '', 'c_order' => '0', 'status' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now())
        );

        DB::table('pages')->insert($dataArr);
        $this->command->info('pages table seeded!');
    }
}
