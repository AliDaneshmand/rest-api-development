<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert new user with $1300 budget
        DB::table('users')->insert([
            'name'      => 'Ali', 
            'email'     => 'a@a.com', 
            'budget'    => 1300.0, 
            'password'  => bcrypt('123456'),
        ]);
    }
}
