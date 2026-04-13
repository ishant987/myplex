<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ModuleClassSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(ModuleMethodsSeeder::class);
        $this->call(RoleModuleMethodRightsSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(AuthRolesSeeder::class);
        $this->call(OptionsSeeder::class);
        $this->call(MenuTypeSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(CustomFieldTypeSeeder::class);
    }
}
