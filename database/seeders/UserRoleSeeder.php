<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
       
        DB::table('roles')->insert([
            'id' => '1',
            'name' => 'Admin',
            'code' => 'admin',
        ]);

        DB::table('roles')->insert([
            'id' => '2',
            'name' => 'Support',
            'code' => 'support',
        ]);

        DB::table('roles')->insert([
            'id' => '3',
            'name' => 'Guest',
            'code' => 'guest',
        ]);

        DB::table('users')->insert([
            'id' => '100',
            'name' => 'webmaster',
            'email' => 'webmaster@laraapp.com',
            'password' => bcrypt('password'),
            'role_id' => '1'
            // 'password' => 1,
        ]);

    }
}
