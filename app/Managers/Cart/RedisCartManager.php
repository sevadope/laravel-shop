<?php

namespace App\Managers\Cart;

use App\Contracts\CartManagerInterface;
use \RedisManager;
use App\Models\CartItem;

class RedisCartManager implements CartManagerInterface
{
	public function getPlain($name, $key)
	{	
		return ($res = RedisManager::command('hget', [$name, $key])) === false ?
			'[]' : $res;
	}

	public function get($name, $key)
	{
		$plain = $this->getPlain($name, $key);
		$arr = json_decode($plain, true);
		
		$items = array_map(function ($item) {
			return CartItem::makeFromArray($item);
		}, $arr);

		return $items;
	}						

	public function set($name, $key, $data)
	{
		if (!is_string($data)) {
			$data = json_encode($data);
		}	
		return RedisManager::command('hset', [$name, $key, $data]);
	}
}