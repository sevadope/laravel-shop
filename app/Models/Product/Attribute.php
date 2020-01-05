<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'products_attributes';

    protected $fillable = [
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function values()
    {
    	return $this->hasMany(AttributeValue::Class, 'attribute_id');
    }

    public function used_values()
    {
    	return $this->belongsToMany(
    		AttributeValue::class,
    		'products_attributes_values',
    		'attribute_id'
    	);
    }

    /*|==========| Accessors |==========|*/

    public function getValueAttribute()
    {
        return $this->getOriginal('pivot_value');
    }
}
