<?php

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
        $now = date("Y-m-d H:i:s"); // Get current time by Mysql format
        // Add users.
        $roles = [
            [
                'id' => 1,
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'role' => 'broadcaster',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'role' => 'writter',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'role' => 'viewer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('roles')->insert($roles);
    }
}
