<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('module_methods')) {
            return;
        }

        $methodId = DB::table('module_methods')
            ->where('route_link', 'admin.settings.razorpay')
            ->value('method_id');

        if (!$methodId) {
            return;
        }

        $moduleId = DB::table('module_methods')
            ->where('method_id', $methodId)
            ->value('module_id');

        DB::table('module_methods')
            ->where('method_id', $methodId)
            ->update([
                'title' => 'Razorpay',
                'method_name' => 'editRazorpay',
                'affected_route_link' => null,
                'is_left_nav' => 1,
                'is_external_link' => 0,
                'c_order' => 4,
                'updated_id' => 1,
                'updated_at' => null,
            ]);

        if ($moduleId && Schema::hasTable('role_module_method_rights')) {
            $exists = DB::table('role_module_method_rights')
                ->where('role_id', 1)
                ->where('module_id', $moduleId)
                ->where('method_id', $methodId)
                ->exists();

            if (!$exists) {
                DB::table('role_module_method_rights')->insert([
                    'role_id' => 1,
                    'module_id' => $moduleId,
                    'method_id' => $methodId,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]);
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('module_methods')) {
            return;
        }

        DB::table('module_methods')
            ->where('route_link', 'admin.settings.razorpay')
            ->update([
                'is_left_nav' => 0,
                'updated_id' => 1,
                'updated_at' => null,
            ]);
    }
};
