<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OptionValue;
use App\Models\Product\Option;
use App\Models\Product\SpecificationValue;
use App\Models\Product\Specification;
use App\Relations\HasOptions;
use App\Contracts\Cache\Cacheable;
use \Serializable;

class Product extends Model implements Cacheable, Serializable
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

	public function scopeWhereRouteKey($query, $key)
	{
		return $query->where($this->getRouteKeyName(), $key);
	}

	public function scopeWhereRouteKeyIn($query, array $keys)
	{
		return $query->whereIn($this->getRouteKeyName(), $keys);
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

	public static function getCachePrefix()
	{
		return 'product:';
	}

	public function buildFromCache(array $data, $cache = null)
	{
		$this->setRawAttributes(array_diff_key($data, ['relations' => 0]));

		if (array_key_exists('relations', $data)) {
			$relations = unserialize($data['relations']);
			$this->setRelations($relations);				
		}

		return $this;
	}

	public function getImageUrl()
	{
		return asset('storage/'.$this->image);
	}

	/*|==========| Serialization |==========|*/

	public function serialize()
	{
		$data = [
			'attributes' => $this->getAttributes(),
			'relations' => $this->getRelations(),
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
