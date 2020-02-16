<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;

class ProductService
{
	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	private const CACHED_ACTIONS = [
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

	public function get($key)
	{
		if ($this->cached(__FUNCTION__)) {
			$cache = $this->app->make(CacheManager::class);

			$fields = $cache->getAllArrayValues(Product::getCachePrefix().$key);

			return (new Product)->buildFromCache($fields);

		} else {
			return Product::
				with('options', 'specifications')
				->whereRouteKey($key)
				->first();
		}
	}	

	public function getQueryForCategoryDescendants(Category $category)
	{
		if ($category->hasDescendants()) {
			$products = Product::whereCategoriesIn(
				$category->descendants->pluck($category->getKeyName())
			);
		} else {
			$products = Product::whereCategory($category->getKey());
		}

		return $products;
	}

	private function cached(string $func)
	{
		return in_array($func, self::CACHED_ACTIONS);
	}
}