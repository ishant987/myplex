<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('modules')) {
            return;
        }

        // 1. Insert/Get class_id in module_class
        $classId = DB::table('module_class')
            ->where('class_name', 'SeoPageController')
            ->value('class_id');

        if (!$classId) {
            $classId = DB::table('module_class')->insertGetId([
                'class_name' => 'SeoPageController',
                'model_name' => 'SeoPage',
                'slug' => 'seo-pages',
                'info' => 'SEO Landing pages and blogs management',
                'status' => 1,
            ]);
        }

        // 2. Insert/Get module_id in modules
        $moduleId = DB::table('modules')
            ->where('class_name', 'SeoPageController')
            ->value('module_id');

        if (!$moduleId) {
            $moduleId = DB::table('modules')->insertGetId([
                'class_id' => $classId,
                'has_templates' => 'n',
                'set_user_rights' => 'n',
                'title' => 'SEO Pages',
                'label' => 'SEO Pages',
                'info' => 'SEO pages and metadata manager',
                'class_name' => 'SeoPageController',
                'is_menu' => 1,
                'c_order' => 21,
                'parent_module_id' => 0,
                'status' => 1,
            ]);
        }

        $now = now();
        $methods = [
            [
                'module_id' => $moduleId,
                'title' => 'SEO Pages List',
                'method_name' => 'index',
                'route_link' => 'admin.seo-pages.index',
                'affected_route_link' => null,
                'is_left_nav' => 1,
                'c_order' => 1,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Create SEO Page',
                'method_name' => 'create',
                'route_link' => 'admin.seo-pages.create',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Store SEO Page',
                'method_name' => 'store',
                'route_link' => 'admin.seo-pages.store',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Edit SEO Page',
                'method_name' => 'edit',
                'route_link' => 'admin.seo-pages.edit',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Update SEO Page',
                'method_name' => 'update',
                'route_link' => 'admin.seo-pages.update',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Delete SEO Page',
                'method_name' => 'destroy',
                'route_link' => 'admin.seo-pages.destroy',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Bulk CSV Import',
                'method_name' => 'bulk',
                'route_link' => 'admin.seo-pages.bulk',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'CSV Template Download',
                'method_name' => 'template',
                'route_link' => 'admin.seo-pages.template',
                'affected_route_link' => 'admin.seo-pages.bulk',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'CSV Preview',
                'method_name' => 'previewCsv',
                'route_link' => 'admin.seo-pages.preview-csv',
                'affected_route_link' => 'admin.seo-pages.bulk',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'CSV Publish',
                'method_name' => 'publishCsv',
                'route_link' => 'admin.seo-pages.publish-csv',
                'affected_route_link' => 'admin.seo-pages.bulk',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Duplicate SEO Page',
                'method_name' => 'duplicate',
                'route_link' => 'admin.seo-pages.duplicate',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
            [
                'module_id' => $moduleId,
                'title' => 'Restore SEO Page Version',
                'method_name' => 'restore',
                'route_link' => 'admin.seo-pages.restore',
                'affected_route_link' => 'admin.seo-pages.index',
                'is_left_nav' => 0,
                'c_order' => 0,
            ],
        ];

        // Get all role IDs currently registered in database
        $roleIds = DB::table('auth_roles')->pluck('role_id')->toArray();
        if (empty($roleIds)) {
            $roleIds = [1, 2]; // Fallback
        }

        foreach ($methods as $method) {
            $methodId = DB::table('module_methods')
                ->where('module_id', $method['module_id'])
                ->where('route_link', $method['route_link'])
                ->value('method_id');

            $methodRow = array_merge($method, [
                'default_present' => 0,
                'access_role_id' => 0,
                'updated_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (!$methodId) {
                $methodId = DB::table('module_methods')->insertGetId($methodRow);
            } else {
                DB::table('module_methods')
                    ->where('method_id', $methodId)
                    ->update([
                        'title' => $method['title'],
                        'method_name' => $method['method_name'],
                        'affected_route_link' => $method['affected_route_link'],
                        'is_left_nav' => $method['is_left_nav'],
                        'c_order' => $method['c_order'],
                        'updated_at' => $now,
                    ]);
            }

            // Grant rights to all roles
            foreach ($roleIds as $roleId) {
                $exists = DB::table('role_module_method_rights')
                    ->where('role_id', $roleId)
                    ->where('module_id', $moduleId)
                    ->where('method_id', $methodId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_module_method_rights')->insert([
                        'role_id' => $roleId,
                        'module_id' => $moduleId,
                        'method_id' => $methodId,
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
        if (!Schema::hasTable('modules')) {
            return;
        }

        $moduleId = DB::table('modules')
            ->where('class_name', 'SeoPageController')
            ->value('module_id');

        if ($moduleId) {
            if (Schema::hasTable('role_module_method_rights')) {
                DB::table('role_module_method_rights')
                    ->where('module_id', $moduleId)
                    ->delete();
            }

            if (Schema::hasTable('module_methods')) {
                DB::table('module_methods')
                    ->where('module_id', $moduleId)
                    ->delete();
            }

            DB::table('modules')
                ->where('module_id', $moduleId)
                ->delete();
        }

        DB::table('module_class')
            ->where('class_name', 'SeoPageController')
            ->delete();
    }
};
