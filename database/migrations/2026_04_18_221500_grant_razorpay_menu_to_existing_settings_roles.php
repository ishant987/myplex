<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('module_methods') || !Schema::hasTable('role_module_method_rights')) {
            return;
        }

        $razorpayMethod = DB::table('module_methods')
            ->where('route_link', 'admin.settings.razorpay')
            ->first(['method_id', 'module_id']);

        $generalMethod = DB::table('module_methods')
            ->where('route_link', 'admin.settings.general')
            ->first(['method_id', 'module_id']);

        if (!$razorpayMethod || !$generalMethod) {
            return;
        }

        $roleIds = DB::table('role_module_method_rights')
            ->where('module_id', $generalMethod->module_id)
            ->where('method_id', $generalMethod->method_id)
            ->whereNull('deleted_at')
            ->pluck('role_id');

        foreach ($roleIds as $roleId) {
            $exists = DB::table('role_module_method_rights')
                ->where('role_id', $roleId)
                ->where('module_id', $razorpayMethod->module_id)
                ->where('method_id', $razorpayMethod->method_id)
                ->whereNull('deleted_at')
                ->exists();

            if (!$exists) {
                DB::table('role_module_method_rights')->insert([
                    'role_id' => $roleId,
                    'module_id' => $razorpayMethod->module_id,
                    'method_id' => $razorpayMethod->method_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]);
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('module_methods') || !Schema::hasTable('role_module_method_rights')) {
            return;
        }

        $razorpayMethod = DB::table('module_methods')
            ->where('route_link', 'admin.settings.razorpay')
            ->first(['method_id', 'module_id']);

        $generalMethod = DB::table('module_methods')
            ->where('route_link', 'admin.settings.general')
            ->first(['method_id', 'module_id']);

        if (!$razorpayMethod || !$generalMethod) {
            return;
        }

        $roleIds = DB::table('role_module_method_rights')
            ->where('module_id', $generalMethod->module_id)
            ->where('method_id', $generalMethod->method_id)
            ->whereNull('deleted_at')
            ->pluck('role_id');

        DB::table('role_module_method_rights')
            ->where('module_id', $razorpayMethod->module_id)
            ->where('method_id', $razorpayMethod->method_id)
            ->whereIn('role_id', $roleIds)
            ->delete();
    }
};
