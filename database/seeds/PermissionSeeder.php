<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id'           => 1,
                'name'         => "adminpanel",
                'display_name' => "Admin Panel",
                'description'  => "Admin Panel",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 2,
                'name'         => "dashboard",
                'display_name' => "Dashboard",
                'description'  => "Dashboard",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 3,
                'name'         => "permissions.index",
                'display_name' => "List Permissions",
                'description'  => "List Permissions",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 4,
                'name'         => "permissions.create",
                'display_name' => "Create Permission",
                'description'  => "Create Permission",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 5,
                'name'         => "permissions.show",
                'display_name' => "View Permission",
                'description'  => "View Permission",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 6,
                'name'         => "permissions.edit",
                'display_name' => "Edit Permission",
                'description'  => "Edit Permission",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 7,
                'name'         => "permissions.destroy",
                'display_name' => "Delete Permission",
                'description'  => "Delete Permission",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 8,
                'name'         => "roles.index",
                'display_name' => "List Roles",
                'description'  => "List Roles",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 9,
                'name'         => "roles.create",
                'display_name' => "Create Role",
                'description'  => "Create Role",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 10,
                'name'         => "roles.show",
                'display_name' => "View Role",
                'description'  => "View Role",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 11,
                'name'         => "roles.edit",
                'display_name' => "Edit Role",
                'description'  => "Edit Role",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 12,
                'name'         => "roles.destroy",
                'display_name' => "Delete Role",
                'description'  => "Delete Role",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 13,
                'name'         => "users.index",
                'display_name' => "List Roles",
                'description'  => "List Roles",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 14,
                'name'         => "users.create",
                'display_name' => "Create Users",
                'description'  => "Create Users",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 15,
                'name'         => "users.show",
                'display_name' => "View User",
                'description'  => "View User",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 16,
                'name'         => "users.edit",
                'display_name' => "Edit User",
                'description'  => "Edit User",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 17,
                'name'         => "users.destroy",
                'display_name' => "Delete User",
                'description'  => "Delete User",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 18,
                'name'         => "modules.index",
                'display_name' => "List Modules",
                'description'  => "List Modules",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 19,
                'name'         => "modules.create",
                'display_name' => "Create Module",
                'description'  => "Create Module",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 20,
                'name'         => "modules.show",
                'display_name' => "View Module",
                'description'  => "View Module",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 21,
                'name'         => "modules.edit",
                'display_name' => "Edit Module",
                'description'  => "Edit Module",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 22,
                'name'         => "modules.destroy",
                'display_name' => "Delete Module",
                'description'  => "Delete Module",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 23,
                'name'         => "languages.index",
                'display_name' => "List Languages",
                'description'  => "List Languages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 24,
                'name'         => "languages.create",
                'display_name' => "Create Languages",
                'description'  => "Create Languages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 25,
                'name'         => "languages.show",
                'display_name' => "View Languages",
                'description'  => "View Languages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 26,
                'name'         => "languages.edit",
                'display_name' => "Edit Languages",
                'description'  => "Edit Languages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 27,
                'name'         => "languages.destroy",
                'display_name' => "Delete Languages",
                'description'  => "Delete Languages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 28,
                'name'         => "pages.index",
                'display_name' => "List Pages",
                'description'  => "List Pages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 29,
                'name'         => "pages.create",
                'display_name' => "Create Pages",
                'description'  => "Create Pages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 30,
                'name'         => "pages.show",
                'display_name' => "View Pages",
                'description'  => "View Pages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 31,
                'name'         => "pages.edit",
                'display_name' => "Edit Pages",
                'description'  => "Edit Pages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 32,
                'name'         => "pages.destroy",
                'display_name' => "Delete Pages",
                'description'  => "Delete Pages",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 33,
                'name'         => "contactus.index",
                'display_name' => "List Contact Us",
                'description'  => "List Contact Us Record",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 34,
                'name'         => "contactus.create",
                'display_name' => "Create Contact Us",
                'description'  => "Create Contact Us Record",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 35,
                'name'         => "contactus.show",
                'display_name' => "View Contact Us",
                'description'  => "View Contact Us Record",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 36,
                'name'         => "contactus.edit",
                'display_name' => "Edit Contact Us",
                'description'  => "Edit Contact Us Record",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 37,
                'name'         => "contactus.destroy",
                'display_name' => "Delete Contact Us",
                'description'  => "Delete Contact Us Record",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 38,
                'name'         => "notifications.index",
                'display_name' => "List Notification",
                'description'  => "List Notification",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 39,
                'name'         => "notifications.create",
                'display_name' => "Create Notification",
                'description'  => "Create Notification",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 40,
                'name'         => "notifications.show",
                'display_name' => "View Notification",
                'description'  => "View Notification",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 41,
                'name'         => "notifications.edit",
                'display_name' => "Edit Notification",
                'description'  => "Edit Notification",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 42,
                'name'         => "notifications.destroy",
                'display_name' => "Delete Notification",
                'description'  => "Delete Notification",
                'is_protected' => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
