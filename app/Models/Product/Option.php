<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OptionValue;

class Option extends Model
{
	protected $table = 'products_options';

    protected $fillable = [
        'set_id',
    	'data_type',
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function values()
    {
    	return $this->hasMany(OptionValue::class, 'option_id');
    }
}
