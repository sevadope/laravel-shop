<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class SpecificationValue extends Model
{
    protected $table = 'products_specifications_values';

    protected $fillable = [
    	'specification_id',
    	'value',
    ];

    /*|==========| Relationships |==========|*/

    public function specification()
    {
    	return $this->hasOne(Specification::class);
    }
}
