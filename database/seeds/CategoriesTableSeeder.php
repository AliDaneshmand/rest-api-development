<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert three new categories
        DB::table('categories')->insert([
            [
                'title' => 'Home', 
                'priority' => 3, 
            ],
            [
                'title' => 'Gadget', 
                'priority' => 1, 
            ],
            [
                'title' => 'Sport', 
                'priority' => 2, 
            ],
        ]);
    }
}
