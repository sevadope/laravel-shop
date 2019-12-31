<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductOption;

class ProductsOptionsSet extends Model
{
    protected $fillable = [
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function options()
    {
    	return $this->hasMany(ProductOption::class, 'set_id');
    }
}
