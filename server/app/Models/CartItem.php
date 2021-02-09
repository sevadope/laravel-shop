<?php

namespace App\Models;

use App\Models\Product;
use \Serializable;
use Illuminate\Contracts\Support\Arrayable;

class CartItem implements Serializable, Arrayable
{
	/**
	 * Primary key of item's product
	 *
	 * @var string
	 **/
	protected $product_key;

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

	/**
	 * Total price of item
	 *
	 * @var string
	 **/
	protected $total_price;

	/**
	 * Selected options of product
	 *
	 * @var string
	 **/
	protected $options;

	public function __construct(Product $product, int $count, array $options = [])
	{
		$this->product = $product;
		$this->count = $count;
		$this->options = $options;
		$this->product_key = $product->getRouteKey();
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

	public function addProducts(int $count)
	{
		$this->count += $count;
	}

	public function setProduct(Product $product)
	{
		$this->product = $product;

		return $this;
	}

	public function getProduct()
	{
		return $this->product;
	}

	public function getProductKey()
	{
		return $this->product_key;
	}

	public function getCount()
	{
		return $this->count;
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function getTotalPrice()
	{
		return $this->total_price ?? $this->total_price = round($this->product->price * $this->count, 2);
	}

	public function toArray()
	{
		return [
			'product' => $this->product,
			'count' => $this->count,
			'options' => $this->options,
			'total_price' => $this->total_price,
		];
	}

	/*|==========| Serialization |==========|*/

	public function serialize()
	{
		$data = [
			'product_key' => $this->product_key,
			'total_price' => $this->getTotalPrice(),
			'count' => $this->count,
			'options' => $this->options,

		];

		return serialize($data);
	}

	public function unserialize($data)
	{
		$data = unserialize($data);

		$this->product_key = $data['product_key'];
		$this->total_price = $data['total_price'];
		$this->count = $data['count'];
		$this->options = $data['options'];
	}
}
