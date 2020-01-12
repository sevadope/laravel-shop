<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Option;

class OptionValue extends Model
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
}
