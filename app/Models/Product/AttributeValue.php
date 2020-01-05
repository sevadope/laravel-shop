<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'products_attributes_values';

    protected $fillable = [
    	'attribute_id',
    	'value',
    ];

    /*|==========| Relationships |==========|*/

    public function attribute()
    {
    	return $this->hasOne(Attribute::class);
    }
}
