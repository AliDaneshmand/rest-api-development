<?php

namespace AliAssignment;

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
        'name', 'price', 'discount', 'fk_category', 'cost',
    ];
    
    /*
     * Relationship with AliAssignment\Category.
     */
    public function category()
    {
        return $this->belongsTo('AliAssignment\Category', 'fk_category');
    }
}
