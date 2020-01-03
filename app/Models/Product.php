<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OptionValue;
use App\Models\Product\Option;
use App\Models\Product\AttributeValue;
use App\Models\Product\Attribute;

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

	public function options()
	{
		return $this->belongsToMany(
			Option::class,
			'products_to_options_values_rel',
			'product_id',
			'option_id'
		);
	}

	public function loadOptionsValues()
	{
		$key = $this->getKey();

		$this->options
			->load(['used_values' => function ($query) use ($key) {
				$query->wherePivot(
					'product_id',
					$key
				);
		}]);	
	}

	public function rel_attributes()
	{
		return $this->hasMany(
			Attribute::class,
			'product_id'
		);
	}

	public function loadDetails()
	{
		$this->loadOptionsValues();
		$this->rel_attributes;
		return $this;
	}
}
