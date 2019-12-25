<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsOption;

class ProductsOptionValue extends Model
{
    protected $fillable = [
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function option()
    {
    	return $this->belongsTo(ProductsOption::class);
    }
}
