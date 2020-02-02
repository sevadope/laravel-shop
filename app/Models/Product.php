<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OptionValue;
use App\Models\Product\Option;
use App\Models\Product\SpecificationValue;
use App\Models\Product\Specification;
use App\Relations\HasOptions;
use App\Contracts\Cache\Cacheable;

class Product extends Model implements Cacheable
{
	protected $fillable = [
		'id',	
		'price',
		'name',
		'slug',
		'options',
		'description',
		'popularity',
		'image',
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
		return $query->get(['id', 'name', 'slug', 'price', 'image',]);
	}

	/*|==========| Relationships |==========|*/

	public function options()
	{
		return new HasOptions(
			OptionValue::query(),
			$this,
			Option::class,
			'products_to_options_values_rel'
		);
	}

	public function specifications()
	{
		return $this->belongsToMany(
			Specification::class,
			'products_specifications_values',
			'product_id',
			'specification_id'
		)->withPivot('value');
	}

	/*|====================|*/

	public function getRouteKeyName()
	{
		return 'slug';
	}

	public static function getCacheListName()
	{
		return 'products';
	}

	public function getImageUrl()
	{
		return asset('storage/'.$this->image);
	}
}
