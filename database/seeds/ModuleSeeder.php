<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'id'           => 1,
                'name'         => "Admin Panel",
                'slug'         => "adminpanel",
                'table_name'   => "-",
                'icon'         => "fa fa-dashboard",
                'is_module'    => 0,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 2,
                'name'         => "Dashboard",
                'slug'         => "dashboard",
                'table_name'   => "-",
                'icon'         => "fa fa-dashboard",
                'is_module'    => 0,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 3,
                'name'         => "Users",
                'slug'         => "users",
                'table_name'   => "users",
                'icon'         => "fa fa-user",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 4,
                'name'         => "Roles",
                'slug'         => "roles",
                'table_name'   => "roles",
                'icon'         => "fa fa-edit",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 5,
                'name'         => "Permissions",
                'slug'         => "permissions",
                'table_name'   => "permissions",
                'icon'         => "fa fa-check-square-o",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 6,
                'name'         => "Modules",
                'slug'         => "modules",
                'table_name'   => "modules",
                'icon'         => "fa fa-database",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 7,
                'name'         => "Languages",
                'slug'         => "languages",
                'table_name'   => "locales",
                'icon'         => "fa fa-comments-o",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 8,
                'name'         => "Page",
                'slug'         => "pages",
                'table_name'   => "pages",
                'icon'         => "fa fa-wpforms",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 9,
                'name'         => "ContactUs",
                'slug'         => "contactus",
                'table_name'   => "admin_queries",
                'icon'         => "fa fa-mail-forward",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ], [
                'id'           => 10,
                'name'         => "Notification",
                'slug'         => "notifications",
                'table_name'   => "notifications",
                'icon'         => "fa fa-bell",
                'is_module'    => 1,
                'status'       => 1,
                'config'       => null,
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
