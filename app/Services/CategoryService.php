<?php

namespace App\Services;

use App\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	private const CACHED_ACTIONS = [
		'getList',
		'getWithDetails',
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

			$plain = $cache->getFirstScoreValues(Category::CACHED_LIST_NAME, $list_size);

			$categories = array_map(function ($item) {
				return unserialize($item);
			}, $plain);

			return $categories;

		} else {
	        return Category::orderByPopularity()
	            ->limit($list_size)
	            ->get();
		}
		
	}

	public function getWithDetails()
	{
		if ($this->cached(__FUNCTION__)) {
			$cache = $this->app->make(CacheManager::class);
		} else {

		}
	}

	/**
	 * Check if action is support caching
	 **/
	private function cached(string $func)
	{
		return in_array($func, static::CACHED_ACTIONS);
	}
}