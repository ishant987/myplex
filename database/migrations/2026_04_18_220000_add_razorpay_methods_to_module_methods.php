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

        $settingsModuleId = DB::table('module_methods')
            ->where('route_link', 'admin.settings.general')
            ->value('module_id');

        if (!$settingsModuleId) {
            $settingsModuleId = DB::table('module_methods')
                ->where('route_link', 'admin.settings.options')
                ->value('module_id');
        }

        if (!$settingsModuleId) {
            return;
        }

        $now = now();
        $rows = [
            [
                'module_id' => $settingsModuleId,
                'title' => 'Razorpay',
                'method_name' => 'editRazorpay',
                'default_present' => 0,
                'access_role_id' => 0,
                'route_link' => 'admin.settings.razorpay',
                'affected_route_link' => null,
                'is_left_nav' => 1,
                'is_external_link' => 0,
                'c_order' => 4,
                'updated_id' => 1,
                'created_at' => $now,
                'updated_at' => null,
            ],
            [
                'module_id' => $settingsModuleId,
                'title' => 'Razorpay Update',
                'method_name' => 'updateRazorpay',
                'default_present' => 0,
                'access_role_id' => 0,
                'route_link' => 'admin.settings.razorpay.update',
                'affected_route_link' => 'admin.settings.razorpay',
                'is_left_nav' => 0,
                'is_external_link' => 0,
                'c_order' => 0,
                'updated_id' => 1,
                'created_at' => $now,
                'updated_at' => null,
            ],
        ];

        foreach ($rows as $row) {
            $existingMethodId = DB::table('module_methods')
                ->where('module_id', $row['module_id'])
                ->where('route_link', $row['route_link'])
                ->value('method_id');

            if (!$existingMethodId) {
                DB::table('module_methods')->insert($row);
                $existingMethodId = DB::getPdo()->lastInsertId();
            } else {
                DB::table('module_methods')
                    ->where('method_id', $existingMethodId)
                    ->update([
                        'title' => $row['title'],
                        'method_name' => $row['method_name'],
                        'affected_route_link' => $row['affected_route_link'],
                        'is_left_nav' => $row['is_left_nav'],
                        'is_external_link' => $row['is_external_link'],
                        'c_order' => $row['c_order'],
                        'updated_id' => $row['updated_id'],
                        'updated_at' => null,
                    ]);
            }

            if (Schema::hasTable('role_module_method_rights') && $row['route_link'] === 'admin.settings.razorpay') {
                $exists = DB::table('role_module_method_rights')
                    ->where('role_id', 1)
                    ->where('module_id', $row['module_id'])
                    ->where('method_id', $existingMethodId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_module_method_rights')->insert([
                        'role_id' => 1,
                        'module_id' => $row['module_id'],
                        'method_id' => $existingMethodId,
                        'created_at' => $now,
                        'updated_at' => $now,
                        'deleted_at' => null,
                    ]);
                }
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('module_methods')) {
            return;
        }

        if (Schema::hasTable('role_module_method_rights')) {
            $methodIds = DB::table('module_methods')
                ->whereIn('route_link', [
                    'admin.settings.razorpay',
                    'admin.settings.razorpay.update',
                ])
                ->pluck('method_id');

            DB::table('role_module_method_rights')
                ->whereIn('method_id', $methodIds)
                ->delete();
        }

        DB::table('module_methods')
            ->whereIn('route_link', [
                'admin.settings.razorpay',
                'admin.settings.razorpay.update',
            ])
            ->delete();
    }
};
