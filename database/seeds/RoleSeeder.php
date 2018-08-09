<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id'           => 1,
                'name'         => "super-admin",
                'display_name' => "Super Admin",
                'is_protected' => 1,
                'description'  => "Super Admin has all permissions",
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 2,
                'name'         => "admin",
                'display_name' => "Administrators",
                'is_protected' => 1,
                'description'  => "Assign this role to all the users who are administrators.",
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'           => 3,
                'name'         => "authenticated",
                'display_name' => "Authenticated",
                'is_protected' => 0,
                'description'  => "Authenticated users will be able to access front-end functionality",
                'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'   => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

        DB::table('permission_role')->insert([
            [
                'permission_id' => 1,
                'role_id'       => 1
            ],
            [
                'permission_id' => 2,
                'role_id'       => 1
            ],
            [
                'permission_id' => 3,
                'role_id'       => 1
            ],
            [
                'permission_id' => 4,
                'role_id'       => 1
            ],
            [
                'permission_id' => 5,
                'role_id'       => 1
            ],
            [
                'permission_id' => 6,
                'role_id'       => 1
            ],
            [
                'permission_id' => 7,
                'role_id'       => 1
            ],
            [
                'permission_id' => 8,
                'role_id'       => 1
            ],
            [
                'permission_id' => 9,
                'role_id'       => 1
            ],
            [
                'permission_id' => 10,
                'role_id'       => 1
            ],
            [
                'permission_id' => 11,
                'role_id'       => 1
            ],
            [
                'permission_id' => 12,
                'role_id'       => 1
            ],
            [
                'permission_id' => 13,
                'role_id'       => 1
            ],
            [
                'permission_id' => 14,
                'role_id'       => 1
            ],
            [
                'permission_id' => 15,
                'role_id'       => 1
            ],
            [
                'permission_id' => 16,
                'role_id'       => 1
            ],
            [
                'permission_id' => 17,
                'role_id'       => 1
            ],
            [
                'permission_id' => 18,
                'role_id'       => 1
            ],
            [
                'permission_id' => 19,
                'role_id'       => 1
            ],
            [
                'permission_id' => 20,
                'role_id'       => 1
            ],
            [
                'permission_id' => 21,
                'role_id'       => 1
            ],
            [
                'permission_id' => 22,
                'role_id'       => 1
            ],
            [
                'permission_id' => 23,
                'role_id'       => 1
            ],
            [
                'permission_id' => 24,
                'role_id'       => 1
            ],
            [
                'permission_id' => 25,
                'role_id'       => 1
            ],
            [
                'permission_id' => 26,
                'role_id'       => 1
            ],
            [
                'permission_id' => 27,
                'role_id'       => 1
            ],
            [
                'permission_id' => 28,
                'role_id'       => 1
            ],
            [
                'permission_id' => 29,
                'role_id'       => 1
            ],
            [
                'permission_id' => 30,
                'role_id'       => 1
            ],
            [
                'permission_id' => 31,
                'role_id'       => 1
            ],
            [
                'permission_id' => 32,
                'role_id'       => 1
            ],
            [
                'permission_id' => 33,
                'role_id'       => 1
            ],
            [
                'permission_id' => 34,
                'role_id'       => 1
            ],
            [
                'permission_id' => 35,
                'role_id'       => 1
            ],
            [
                'permission_id' => 36,
                'role_id'       => 1
            ],
            [
                'permission_id' => 37,
                'role_id'       => 1
            ],
            [
                'permission_id' => 38,
                'role_id'       => 1
            ],
            [
                'permission_id' => 39,
                'role_id'       => 1
            ],
            [
                'permission_id' => 40,
                'role_id'       => 1
            ],
            [
                'permission_id' => 41,
                'role_id'       => 1
            ],
            [
                'permission_id' => 42,
                'role_id'       => 1
            ],
            [
                'permission_id' => 1,
                'role_id'       => 2
            ],
            [
                'permission_id' => 2,
                'role_id'       => 2
            ],
            [
                'permission_id' => 8,
                'role_id'       => 2
            ],
            [
                'permission_id' => 9,
                'role_id'       => 2
            ],
            [
                'permission_id' => 10,
                'role_id'       => 2
            ],
            [
                'permission_id' => 11,
                'role_id'       => 2
            ],
            [
                'permission_id' => 12,
                'role_id'       => 2
            ],
            [
                'permission_id' => 13,
                'role_id'       => 2
            ],
            [
                'permission_id' => 14,
                'role_id'       => 2
            ],
            [
                'permission_id' => 15,
                'role_id'       => 2
            ],
            [
                'permission_id' => 16,
                'role_id'       => 2
            ],
            [
                'permission_id' => 17,
                'role_id'       => 2
            ],
            [
                'permission_id' => 23,
                'role_id'       => 2
            ],
            [
                'permission_id' => 24,
                'role_id'       => 2
            ],
            [
                'permission_id' => 25,
                'role_id'       => 2
            ],
            [
                'permission_id' => 26,
                'role_id'       => 2
            ],
            [
                'permission_id' => 27,
                'role_id'       => 2
            ],
            [
                'permission_id' => 28,
                'role_id'       => 2
            ],
            [
                'permission_id' => 29,
                'role_id'       => 2
            ],
            [
                'permission_id' => 30,
                'role_id'       => 2
            ],
            [
                'permission_id' => 31,
                'role_id'       => 2
            ],
            [
                'permission_id' => 32,
                'role_id'       => 2
            ],
            [
                'permission_id' => 33,
                'role_id'       => 2
            ],
            [
                'permission_id' => 34,
                'role_id'       => 2
            ],
            [
                'permission_id' => 35,
                'role_id'       => 2
            ],
            [
                'permission_id' => 36,
                'role_id'       => 2
            ],
            [
                'permission_id' => 37,
                'role_id'       => 2
            ],
            [
                'permission_id' => 38,
                'role_id'       => 2
            ],
            [
                'permission_id' => 39,
                'role_id'       => 2
            ],
            [
                'permission_id' => 40,
                'role_id'       => 2
            ],
            [
                'permission_id' => 41,
                'role_id'       => 2
            ],
            [
                'permission_id' => 42,
                'role_id'       => 2
            ],
        ]);
    }
}
