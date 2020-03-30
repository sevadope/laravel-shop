<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use \Serializable;
use Illuminate\Contracts\Support\Arrayable;

class Specification extends Model implements Serializable, Arrayable
{
    protected $table = 'products_specifications';

    protected $fillable = [
    	'name',
        'value'
    ];

    public function getValueAttribute()
    {
        return $this->pivot ?
            $this->pivot->value
            : null;   
    }

    public function toArray()
    {
        $attrs = $this->getAttributes();
        $attrs['value'] = $attrs['value'] ?? $this->pivot->value;

        return $attrs;
    }

    /*|==========| Relationships |==========|*/

    public function values()
    {
    	return $this->hasMany(SpecificationValue::Class, 'specification_id');
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
