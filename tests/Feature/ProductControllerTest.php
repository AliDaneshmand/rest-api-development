<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductControllerTest extends TestCase
{
    /**
     * GET Route test with address: output.json
     *
     * @return void
     */
    public function testOutput()
    {
        $response = $this->get('/output.json');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*' => [
                        'name', 'price', 'discount', 'type', 'cost',
                    ],
                 ]);
    }
    
    /*
     * POST Route test with address: input.json
     */
    public function testInput()
    {
        $response = $this->json('POST', '/input.json', [
            'name' => 'TestProduct',
            'price' => '500',
            'discount' => '$15',
            'type' => 'Gadget',
            'cost' => '350',
        ]);
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'successful', 'id', 'name',
                 ]);
    }
}
