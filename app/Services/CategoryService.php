<?php

namespace App\Services;

use App\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Concerns\CanCacheActions;

class CategoryService
{
	use CanCacheActions;

	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	protected $cached_actions = [
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

			$category = (new Category)->buildFromCache($fields, $cache);

			return $category;

		} else {
			return Category::
				with('descendants', 'ancestors')
				->whereRouteKey($key)
				->first();
		}
	}

	protected function getCachedActions()
	{
		return $this->cached_actions;
	}
}