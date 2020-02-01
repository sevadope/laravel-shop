<?php

namespace App\Cache;

use Illuminate\Cache\RedisStore as Store;
use App\Contracts\Cache\SupportsAssocArray;

class RedisStore extends Store implements SupportsAssocArray
{
	public function getArrayValue($name, $key)
	{
		return $this->connection()->command('hget', [$name, $key]);
	}

	public function putArrayKey($name, $key, $value)
	{
		return $this->connection()->command('hset', [$name, $key, $value]);
	}
}