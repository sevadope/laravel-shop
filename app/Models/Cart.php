<?php

namespace App\Models;

use App\Contracts\CartManagerInterface;
use App\Models\CartItem;

class Cart 
{
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

	protected function refresh($key = null)
	{
		$key = $key ?? $this->pk;
		$this->items = $this->manager->get(static::LIST_NAME, $key);
	}
}
