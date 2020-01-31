<?php

namespace App\Models;

use App\Contracts\CartManagerInterface;
use App\Models\CartItem;

class Cart 
{
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
	 * Name of carts list from DB
	 *
	 * @var string
	 **/
	public const LIST_NAME = 'carts';

	/**
	 * Cart's items
	 *
	 * @var CartItem[]
	 **/
	protected $items;

	/**
	 * Cart manager implements App\Contracts\CartManagerInterface
	 *
	 * @var obj
	 **/
	protected $manager;


	function __construct($key = null)
	{
		$this->pk = $key;
		$this->manager = app()->make(CartManagerInterface::class);
		$this->refresh($key);
	}

	public static function get($key)
	{
		return new static($key);
	}

	public static function getPlain($key)
	{
		if (is_null($key)) {
			return;
		}

		return (new static)->manager->getPlain(static::LIST_NAME, $key);
	}

	public function getItems()
	{
		return $this->items;
	}

	public function getItemsCount()
	{
		return $this->items_count ?? $this->items_count = count($this->items);
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getTotalPrice()
	{
		return $this->total_price;
	}

	protected function refresh($key = null)
	{
		// refresh pk
		$key = $key ?? $this->pk;
		$this->items = $this->manager->get(static::LIST_NAME, $key);

		// refresh size and total price
		$size = 0;
		$total_price = 0;

		array_walk($this->items, function ($item) use (&$size, &$total_price) {
			$size += $item->getCount();
			$total_price += $item->getTotalPrice();
		});

		$this->size = $size;
		$this->total_price = $total_price;
	}
}
