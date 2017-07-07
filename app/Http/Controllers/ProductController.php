<?php

namespace anetwork\Http\Controllers;

use Illuminate\Http\Request;
use anetwork\User;
use anetwork\Product;
use anetwork\Category;

class ProductController extends Controller
{
    /*
     * Return smart sorted list of product
     * 
     * @return array
     */
    public function output()
    {
        // Assume that the #1 user has beend authenticated
        $user = User::find(1);
        
        // Fetch available 
        $products = Product::where('price', '<', $user->budget)->get();
        
        // Return sorted list of products according to company's benefit
        return $this->smartSort($products);
    }
    
    /*
     * Creating and sorting list of products in a smart way
     * 
     * @param Product[] $products List of products objects
     * 
     * @return array
     */
    private function smartSort(&$products)
    {
        // Empty list
        $list = [];
        
        // Add product and keep them as array
        foreach($products as $product) {
            $this->appendToList($list, $product);
        }
        
        // Sort product according to their benefit and group of benetit
        $list = $this->sortGroups($list);
        
        // Prepare final output and arrange them in a smart way
        $list = $this->makeFinalOutput($list);
        
        return $list;
    }
    
    /*
     * Appending a product to the list according to its group of benefit
     * 
     * @param array $list List of products to add to
     * @param Product $product A product object
     */
    private function appendToList(array &$list, Product &$product)
    {
        // Calculate product benefit
        $benefit = $this->calculateProductBenefit($product);
        
        // Detect group of benefit amount
        $group = floor($benefit / 50);
        
        $list[ $group ][ $benefit ][] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'discount' => $product->discount,
            'type' => $product->category,
            'cost' => $product->cost,
        ];
    }
    
    /*
     * Calculating benefit of a product 
     * 
     * @param Product $product A product object
     */
    private function calculateProductBenefit(Product &$product)
    {
        return ($product->price - $product->cost) - 
               (($product->cost * $product->discount) / 100);
    }
    
    /*
     * Sorting first and second level of the product list
     * 
     * @param array $list List of products
     * 
     * @return array
     */
    private function sortGroups(array &$list)
    {
        $sortedList = [];
        krsort($list);
        $count = count(array_keys($list));
        
        for($i = 0; $i < $count; $i++) {
            $popped = array_pop($list);
            
            // Sort by keys
            krsort($popped);
            
            // Check priority and apply to the list arrangment
            $this->checkCategoryPriority($popped);
            
            // Remove unused benefit values of the products
            $poppedValues = [];
            foreach($popped as $benefit => $products) {
                foreach($products as $product) {
                    $poppedValues[] = $product;
                }
            }
            
            // Add to new sorted list
            $sortedList[ $i ] = $poppedValues;
        }
        
        unset($list);
        
        // Sort by keys
        krsort($sortedList);
        
        return $sortedList;
    }
    
    /*
     * Retrieving all of categoris with their priorities
     * 
     * @return array
     */
    private function getCategoriesPriorities()
    {
        $categories = Category::all();
        $priorities = [];
        
        // make list of categories' ID and their priorities
        foreach($categories as $category) {
            $priorities[ $category->id ] = $category->priority;
        }
        
        return $priorities;
    }
    
    /*
     * Sorting the third level of the product list regard to categories priorities
     * 
     * @return array
     */
    private function checkCategoryPriority(array &$group)
    {
        $priorities = $this->getCategoriesPriorities();
        
        foreach($group as $benefit => $products) {
            $count = count($products);
            
            // Sort products on equal benefit according to their categories priorities
            if($count > 1) {
                for($i = 0; $i < $count - 1; $i++) {
                    for($j = $i + 1; $j < $count; $j++) {
                        $priority_i = $priorities[ $products[ $i ]['type'] ];
                        $priority_j = $priorities[ $products[ $j ]['type'] ];
                        
                        // Exchange tow products
                        if($priority_i >= $priority_j) {
                            $temp = $group[ $benefit ][ $i ];
                            $group[ $benefit ][ $i ] = $group[ $benefit ][ $j ];
                            $group[ $benefit ][ $j ] = $temp;
                        }
                    }
                }
            }
        }
    }
    
    /*
     * Making final list to print in a smart order according to 
     * maximize company's benefit and selling all products.
     * 
     * @param array $list List of grouped and sorted products
     * 
     * @return array
     */
    private function makeFinalOutput(array &$list)
    {
        $output = [];
        $stats = [];
        
        // Collect stats of products in their groups
        for($i = 0; $i < count($list); $i++) {
            $stats[ $i ] = count($list[ $i ]);
        }
        
        // Smart distribution preparation
        $group = count($stats) - 1;
        $block = count($stats) <= 4 ? 4 : count($stats);
        $index = ceil(max(array_values($stats)) / $block);
        
        // Distribute products in smart and regular arrangement
        for($i = 0; $i < $index; $i++) {
            for($j = 0; $j < $block; $j++) {
                for($k = $group; $k >= 0; $k--) {
                    if(isset($list[ $k ][ $i + ($j * $block) ])) {
                        $output[] = $list[ $k ][ $i + ($j * $block) ];
                    }
                }
            }
        }
        
        unset($list);
        return $output;
    }
    
    /*
     * Inserting posted list of products to database
     */
    public function input()
    {
        
    }
}
