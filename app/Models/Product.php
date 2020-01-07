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
		'popularity',
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
		return $this->belongsToMany(
			Attribute::class,
			'products_attributes_values',
			'product_id',
			'attribute_id'
		)->withPivot(['value']);
	}

	public function loadAttributesValues()
	{
		$key = $this->getKey();

		$this->rel_attributes;
	}

	public function loadDetails()
	{
		$this->loadOptionsValues();
		$this->loadAttributesValues();
		
		return $this;
	}

	public function scopeOrderByPopularity($query)
	{
		return $query->orderBy('popularity');
	}

	public function scopeWhereCategory($query, $id)
	{
		return $query->where('category_id', $id);	
	}

	public function scopeWhereCategoryIn($query,  $keys)
	{
		#dd($keys);
		return $query->whereIn('category_id', $keys);
	}

	public function scopeGetForList($query)
	{
		return $query->get(['id', 'name', 'slug']);
	}
}
