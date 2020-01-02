<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OptionValue;
use App\Models\Product\Option;

class Product extends Model
{
	protected $fillable = [
		'price',
		'name',
		'slug',
		'options',
		'description',
	];

	/*|==========| Relationships |==========|*/

	public function options_values()
	{
		return $this->belongsToMany(
			OptionValue::class,
			'products_to_options_values_rel',
			'product_id',
			'value_id',
		);
	}
}
