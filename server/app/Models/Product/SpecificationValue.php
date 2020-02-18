<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use \Serializable;

class SpecificationValue extends Model implements Serializable
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

    /*|==========| Serialization |==========|*/

    public function serialize()
    {
        return serialize($this->getAttributes());
    }

    public function unserialize($data)
    {
        $this->setRawAttributes(unserialize($data));
    }
}
