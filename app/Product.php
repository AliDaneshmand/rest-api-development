<?php

namespace anetwork;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /*
     * Disable crated and updated timpestamps 
     * 
     * @var bool
     */
    public $timestamps = false;
    
    /*
     * Determining fillable fileds of this model
     * 
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'discount', 'category', 'cost',
    ];
}
