<?php

namespace App\Models;

use App\Models\Product;

class CartItem
{
	/**
	 * Current item's product
	 *
	 * @var Product
	 **/
	protected $product;

	/**
	 * Products count
	 *
	 * @var integer
	 **/
	protected $count;

	public function __construct(array $product_fields, int $count)
	{
		$this->product = (new Product)->fill($product_fields);
		$this->count = $count;
	}

	public static function makeFromArray(array $arr)
	{
		// Check if array has undefined properties
		if (!empty($undefined = array_diff_key($arr, get_class_vars(static::class)))) {
			throw new \LogicException("Undefined properties: ${implode(', ', $undefined) }", 1);
		}

		$item = new static($arr['product'], $arr['count']);

		return $item;
	}
}
