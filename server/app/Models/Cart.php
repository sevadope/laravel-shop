<?php

namespace App\Models;

use App\Cache\CacheManager;
use App\Models\CartItem;
use App\Contracts\Cache\Cacheable;
use App\Concerns\CanCacheActions;
use Illuminate\Contracts\Support\Arrayable;

class Cart implements Cacheable, Arrayable
{
	use CanCacheActions;

	/**
	 * cart items count
	 *
	 * @var integer
	 **/
	protected $items_count;

	/**
	 * Products total price
	 *
	 * @var float
	 **/
	protected $total_price;

	/**
	 * Total products count
	 *
	 * @var integer
	 **/
	protected $size;

	/**
	 * Cart's primary key
	 *
	 * @var mixed
	 **/
	protected $pk;

	/**
	 * Cart's items
	 *
	 * @var CartItem[]
	 **/
	protected $items;

	/**
	 * Cart manager implements App\Cache\CacheManager  
	 *
	 * @var obj
	 **/
	public $cache;

	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	protected $cached_actions = [
		'buildFromCache',
	];

	/**
	 * Prefix for items
	 *
	 * @var string
	 **/
	protected $items_prefix;


	function __construct(CacheManager $cache, $key)
	{
		$this->pk = $key;
		$this->cache = $cache;
		$this->refresh($key);
	}

	public function add(Product $product, int $count = 1, array $options = [])
	{
		$item_key = $this->buildCacheKey($product->getKey(), $options);

		if (array_key_exists($item_key, $this->items)) {
			$this->items[$item_key]->addProducts($count);
		} else {
			$this->items[$item_key] = new CartItem($product, $count, $options);
			$this->items_count++;
			$this->total_price += $product->price * $count;			
		}

		$this->size += $count;	
	}

	public function removeItem($key)
	{
		$rm = array_filter($this->items, function ($item) use ($key) {
			return $item->getProduct()->getKey() === $key;
		});

		$item_key = array_keys($rm)[0];

		$res = $this->cache->delArrayValue(
			static::getCachePrefix().$this->pk,
			$item_key
		);

		unset($this->items[$item_key]);
	}

	public function clear()
	{
		$this->items = [];

		$this->items_count = 0;
		$this->total_price = 0;
		$this->size = 0;

		$this->cache->delete(static::getCachePrefix().$this->pk);
	}

	public function save()
	{
		$plain_items = array_map(function ($item) {
			return serialize($item);
		}, $this->items);

		$this->cache->putArrayValues(
			static::getCachePrefix().$this->pk, 
			array_merge(
				$plain_items, 
				$this->getSupportFields()
			)
		);
	}

	public static function buildCacheKey($key, array $options)
	{
		return $key.':options:'.implode(',', $options);
	}


	public static function getCachePrefix()
	{
		return 'user:cart:';	
	}

	public function buildFromCache(array $data, $cache = null)
	{
		$plain_items = array_diff_key(
			$data, 
			$this->getSupportFields()
		);

		$empty_items = array_map(function ($item) {
			return unserialize($item);
		}, $plain_items);

		$items = [];

		if ($this->cached(__FUNCTION__)) {
			foreach ($empty_items as $e_item) {

				// Load product from cache
				$fields = $this->cache->getAllArrayValues(
					Product::getCachePrefix().$e_item->getProductKey()
				);

				// Make product without relations
				$product =(new Product)->buildFromCache(array_diff_key(
					$fields,
					['relations' => 0]
				));

				// Set product to item and set item to cart
				$items[$this->buildCacheKey(
					$product->getKey(),
					$e_item->getOptions()
				)] = $e_item->setProduct($product);
			}	

		} else {
			// Get all products keys from empty items
			$products_keys = array_map(function ($e_item) {
				return $e_item->getProductKey();
			}, $empty_items);

			$products = Product::whereRouteKeyIn($products_keys)->get();

			// Set products to items and set items to cart
			foreach ($empty_items as $e_item) {
				$items[$this->buildCacheKey(
					$e_item->getProductKey(),
					$e_item->getOptions()
				)] = $e_item->setProduct(
					$products->where(
						$products->first()->getRouteKeyName(),
						$e_item->getProductKey()
					)->first()
				);
			}
		}

		return $items;
	}

	public function getItems()
	{
		return $this->items;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getTotalPrice()
	{
		return $this->total_price;
	}

	public function getItemsCount()
	{
		return $this->items_count;
	}

	public function toArray()
	{
		$items = array_map(function ($item) {
			return $item->toArray();
		}, $this->items);

		return array_merge(['items' => array_values($items)], $this->getSupportFields());
	}

	protected function refresh($key = null)
	{
		$key = $key ?? $this->pk;
		
		$response = $this->cache->getAllArrayValues($this->getCachePrefix().$key);

		$size = 0;
		$total_price = 0;
		$items_count = 0;

		$this->items = !empty($response) ? $this->buildFromCache($response) : [];

		foreach ($this->items as $item) {
			$size += $item->getCount();
			$total_price += $item->getTotalPrice();
		}

		$this->size = $size;
		$this->total_price = $total_price;
		$this->items_count = count($this->items);
	}

	protected function getSupportFields()
	{
		return [
			'size' => $this->size,
			'total_price' => $this->total_price,
			'items_count' => $this->items_count,
		];
	}

	protected function getCachedActions()
	{
		return $this->cached_actions;
	}
}
