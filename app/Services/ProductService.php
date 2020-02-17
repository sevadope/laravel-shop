<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use App\Concerns\CanCacheActions;

class ProductService
{
	use CanCacheActions;

	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	protected $cached_actions = [
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

	protected function getCachedActions()
	{
		return $this->cached_actions;
	}
}