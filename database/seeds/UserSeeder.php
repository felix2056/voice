<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s"); // Get current time by Mysql format
        // Add users.
        $admin = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'created_at' => $now,
                'updated_at' => $now,
                'status' => 1,
            ],
        ];
        $role = [
            [
                'id' => 1,
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'role_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'role_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        $admin_profile = [
            [
                'id' => 1,
                'user_id' => 1,
                'avatar' => 'assets/images/users/avatar.png',
                'phone' => 123456789,
                'country_id' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('users')->insert($admin);
        DB::table('user_roles')->insert($role);
        DB::table('user_profiles')->insert($admin_profile);
    }
}
