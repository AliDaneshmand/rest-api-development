<?php

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use anetwork\Category;
use anetwork\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cost = 1;
        
        for($i = 1; $i <= 200; $i++) {
            // Calculate price with benefit
            $benefit = rand(8, 15);
            $price = $cost + (($cost * $benefit) / 100);
            
            // Calculate discount and append to the price
            $upperBound = floor($price % 71);
            $lowerBound = $upperBound < 10 ? 0 : ($i % 10);
            $discount = rand($lowerBound, $upperBound);
            $price += ($price * $discount) / 100;
            
            // Create new fake product
            $this->createProduct([
                'price' => $price,
                'discount' => $discount,
                'category' => Category::inRandomOrder()->first()->id,
                'cost' => $cost,
            ]);
            
            // Monotonic increase cost for next product
            $cost = $i * 10;
        }
        
        // Insert exmaple records seperately
        foreach($this->exampleProducts() as $record) {
            $this->createProduct($record);
        }
    }
    
    /*
     * Create new row in the database table
     * 
     * @param array Fillable fields
     * @return void
     */
    private function createProduct($record)
    {
        $faker = FakerFactory::create();
        
        Product::create(array_merge([
            'name' => $faker->name
        ], $record));
    }
    
    /*
     * Return the default example rocords of the problem
     * 
     * @return array
     */
    private function exampleProducts()
    {
        return [
            [
                'price' => 1200,
                'discount' => 10,
                'category' => Category::where('title', 'Gadget')->first()->id,
                'cost' => 900,
            ],
            [
                'price' => 1270,
                'discount' => 15,
                'category' => Category::where('title', 'Gadget')->first()->id,
                'cost' => 1000,
            ],
            [
                'price' => 1300,
                'discount' => 12,
                'category' => Category::where('title', 'Gadget')->first()->id,
                'cost' => 1100,
            ],
            [
                'price' => 1270,
                'discount' => 15,
                'category' => Category::where('title', 'Sport')->first()->id,
                'cost' => 1000,
            ],
            [
                'price' => 700,
                'discount' => 5,
                'category' => Category::where('title', 'Home')->first()->id,
                'cost' => 500,
            ],
        ];
    }
}
