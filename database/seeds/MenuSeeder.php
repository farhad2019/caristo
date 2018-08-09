<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'id'           => 1,
                'name'         => "Dashboard",
                'icon'         => "fa fa-dashboard",
                'slug'         => "dashboard",
                'position'     => 1,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 2,
                'name'         => "Users",
                'icon'         => "fa fa-user",
                'slug'         => "users",
                'position'     => 2,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 3,
                'name'         => "Roles",
                'icon'         => "fa fa-edit",
                'slug'         => "roles",
                'position'     => 3,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 4,
                'name'         => "Permissions",
                'icon'         => "fa fa-check-square-o",
                'slug'         => "permissions",
                'position'     => 4,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 5,
                'name'         => "Modules",
                'icon'         => "fa fa-database",
                'slug'         => "modules",
                'position'     => 5,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 6,
                'name'         => "Languages",
                'icon'         => "fa fa-comments-o",
                'slug'         => "languages",
                'position'     => 6,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 7,
                'name'         => "Pages",
                'icon'         => "fa fa-wpforms",
                'slug'         => "pages",
                'position'     => 7,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 8,
                'name'         => "Contact us",
                'icon'         => "fa fa-mail-forward",
                'slug'         => "contactus",
                'position'     => 8,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 9,
                'name'         => "Notifications",
                'icon'         => "fa fa-bell",
                'slug'         => "notifications",
                'position'     => 9,
                'is_protected' => 0,
                'status'       => 1,
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
