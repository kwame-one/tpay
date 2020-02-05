<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('roles')->insert([
        	['name' => 'Admin'],
        	['name' => 'Driver'],
        	['name' => 'Normal']
        ]);

        DB::table('users')->insert([
        	[
        		'surname' => 'Admin',
        		'other_names' => 'Test',
        		'contact' => '0572920880',
        		'email' => 'admin@mail.com',
        		'password' => Hash::make('password'),
        		'role_id' => 1

        	]
        ]);


    }
}
