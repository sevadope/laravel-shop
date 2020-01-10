<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $table = 'products_specifications';

    protected $fillable = [
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function values()
    {
    	return $this->hasMany(SpecificationValue::Class, 'specification_id');
    }
}
