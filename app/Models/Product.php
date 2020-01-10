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

	/*|==========| Scopes |==========|*/

	public function scopeOrderByPopularity($query)
	{
		return $query->orderBy('popularity');
	}

	public function scopeWhereCategory($query, $id)
	{
		return $query->where('category_id', $id);	
	}

	public function scopeWhereCategoriesIn($query,  $keys)
	{
		return $query->whereIn('category_id', $keys);
	}

	public function scopeGetForList($query)
	{
		return $query->get(['id', 'name', 'slug']);
	}

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
	
	/*|====================|*/

	public function getRouteKeyName()
	{
		return 'slug';
	}
}
