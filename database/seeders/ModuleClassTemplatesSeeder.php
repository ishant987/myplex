<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ModuleClassTemplatesSeeder extends Seeder
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

        DB::table('module_class_templates')->truncate();

        $dataArr = array(
            array('class_id' => '7', 'template_id' => '1', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('class_id' => '7', 'template_id' => '2', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('class_id' => '7', 'template_id' => '3', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('class_id' => '7', 'template_id' => '4', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('class_id' => '7', 'template_id' => '5', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('class_id' => '7', 'template_id' => '6', 'created_id' => '1', 'updated_id' => '1', 'created_at' => now(), 'updated_at' => now())
        );

        DB::table('module_class_templates')->insert($dataArr);
        $this->command->info('module_class_templates table seeded!');
    }
}
