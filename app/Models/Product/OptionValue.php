<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Option;
use \Serializable;

class OptionValue extends Model implements Serializable
{
	protected $table = 'products_options_values';
	
    protected $fillable = [
    	'value',
        'option_id'
    ];

    /*|==========| Relationships |==========|*/

    public function option()
    {
    	return $this->belongsTo(Option::class);
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
