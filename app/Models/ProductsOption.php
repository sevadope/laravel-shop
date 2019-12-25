<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsOptionValue;

class ProductsOption extends Model
{
    protected $fillable = [
    	'type',
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function values()
    {
    	return $this->hasMany(ProductsOptionValue::class, 'option_id');
    }
}
