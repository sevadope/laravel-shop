<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OptionValue;
use \Serializable;

class Option extends Model implements Serializable
{
	protected $table = 'products_options';

    protected $fillable = [
    	'data_type',
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function all_values()
    {
    	return $this->hasMany(OptionValue::class, 'option_id');
    }

    /*|==========| Serialization |==========|*/

    public function serialize()
    {
        $data = [
            'attributes' => $this->getAttributes(),
            'relations' => $this->relations,
        ];

        return serialize($data);
    }

    public function unserialize($data)
    {
        $data = unserialize($data);

        $this->setRawAttributes($data['attributes']);
        $this->setRelations($data['relations']);
    }
}
