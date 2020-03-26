<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Order extends Model
{
	/*|==========| Relationships |==========|*/

	public function customer()
	{
		return $this->belongsTo(User::class, 'customer_id', 'id');
	}

	public function products()
	{
		return $this->belongsToMany(
			Product::class,
			'order_product',
			'order_id',
			'product_id'
		)->withPivot('options');
	}
}
