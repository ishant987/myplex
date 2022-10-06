<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CustomFieldTypeSeeder extends Seeder
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

        DB::table('custom_field_type')->truncate();

        $dataArr = array(
            array('cf_type_id' => '1', 'title' => 'Text', 'field_type' => 'text', 'field_default_options' => '{"type":"text","label":"Text Field","placeholder":"Dummy Text Field","required":false,"description":"lorem ipsum doler","instruction":"Doler ipsum doler"}', 'c_order' => '1', 'status' => '1', 'created_id' => '1', 'updated_id' => '0', 'created_at' => now(), 'updated_at' => now()),
            array('cf_type_id' => '2', 'title' => 'Image', 'field_type' => 'image', 'field_default_options' => '{"type":"image","label":"Image Field","placeholder":"Dummy image Field","required":false,"description":"lorem ipsum doler","instruction":"Doler ipsum doler"}', 'c_order' => '2', 'status' => '1', 'created_id' => '1', 'updated_id' => '0', 'created_at' => now(), 'updated_at' => now()),
            array('cf_type_id' => '3', 'title' => 'Textarea', 'field_type' => 'textarea', 'field_default_options' => '{"type":"textarea","label":"Textarea Field","placeholder":"Dummy Textarea Field","required":false,"rows":3,"cols":3,"description":"lorem ipsum doler","instruction":"Doler ipsum doler"}', 'c_order' => '3', 'status' => '1', 'created_id' => '1', 'updated_id' => '0', 'created_at' => now(), 'updated_at' => now()),
            array('cf_type_id' => '4', 'title' => 'Editor', 'field_type' => 'editor', 'field_default_options' => '{"type":"editor","label":"Editor Field","placeholder":"Dummy Editor Field","required":false,"rows":3,"cols":3,"description":"lorem ipsum doler","instruction":"Doler ipsum doler"}', 'c_order' => '4', 'status' => '1', 'created_id' => '1', 'updated_id' => '0', 'created_at' => now(), 'updated_at' => now())
        );

        DB::table('custom_field_type')->insert($dataArr);
        $this->command->info('custom_field_type table seeded!');
    }
}
