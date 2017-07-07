<?php


namespace AliAssignment;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /*
     * Relationship with AliAssignment\Product.
     */
    public function product()
    {
        return $this->hasMany('AliAssignment\Product', 'fk_category');
    }
}
