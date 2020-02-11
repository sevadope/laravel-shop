<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use \Serializable;

class Specification extends Model implements Serializable
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

	/*|==========| Accessors |==========|*/

	public function getValueAttribute()
	{
		return $this->pivot->value;
	}

    /*|==========| Serialization |==========|*/

    public function serialize()
    {
        $data = [
            'attributes' => $this->getAttributes(),
        ];
        $data['attributes']['value'] = $this->pivot->value;

        return serialize($data);
    }

    public function unserialize($data)
    {
        $data = unserialize($data);
        $this->setRawAttributes($data['attributes']);
    }

}
