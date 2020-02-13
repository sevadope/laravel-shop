<?php

namespace App\Services;

use App\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	private const CACHED_ACTIONS = [
		'getList',
		'get',
	];

	/**
	 * The application instance
	 * 
	 * @var \Illuminate\Contracts\Foundation\Application
	 **/
	private $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function getList($list_size)
	{
		if ($this->cached(__FUNCTION__)) {
			$cache = $this->app->make(CacheManager::class);

			$keys = $cache->getFirstScoreValues(Category::CACHED_SCORE_NAME, $list_size);

			$categories = $cache->getArrayValues(Category::CACHED_LIST_NAME, $keys);

			return array_map(function ($item) {
				return unserialize($item);
			}, $categories);

		} else {
	        return Category::orderByPopularity()
	            ->limit($list_size)
	            ->get();
		}
		
	}

	public function get($key)
	{
		if ($this->cached(__FUNCTION__)) {
			$cache = $this->app->make(CacheManager::class);

			$fields = $cache->getAllArrayValues(Category::getCachePrefix().$key, $key);

			$category = $this->makeCategory($fields, $cache);

			return $category;

		} else {
			return Category::
				with('descendants', 'ancestors')
				->whereRouteKey($key)
				->first();
		}
	}

	/**
	 * Check if action is support caching
	 **/
	private function cached(string $func)
	{
		return in_array($func, static::CACHED_ACTIONS);
	}

	private function makeCategory($fields, $cache)
	{
		$category = (new Category)->setRawAttributes(array_diff_key($fields, ['relations' => 0]));
		$rel_keys = unserialize($fields['relations']);

		$relations = [];
		foreach ($rel_keys as $rel_name => $rel) {
			if (!empty($rel)) {
				$values = $cache->getArrayValues(Category::CACHED_LIST_NAME, $rel);
				$relations[$rel_name] = new Collection(array_map(function ($value) {
					return unserialize($value);
				}, $values));
			} else {
				$relations[$rel_name] = new Collection;	
			}

		}

		$category->setRelations($relations);

		return $category;
	}
}