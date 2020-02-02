<?php

namespace App\Cache;

use Illuminate\Cache\RedisStore as Store;
use App\Contracts\Cache\SupportsAssocArray;

class RedisStore extends Store implements SupportsAssocArray
{
	public function getArrayValue($name, $key)
	{
		return $this->connection()->hget($this->prefix.$name, $key);
	}

	public function getArrayValues($name, array $values)
	{
		return $this->connection()->hmget($this->prefix.$name, $values);
	}

	public function putArrayValue($name, $key, $value)
	{
		return $this->connection()->hset($this->prefix.$name, $key, $value);
	}

	public function putArrayValues($name, array $values)		
	{
		return $this->connection()->hmset($this->prefix.$name, $values);
	}

	public function getArrayLength($name)
	{
		return $this->connection()->hlen($this->prefix.$name);	
	}

	public function arrayValueExists($name, $key)
	{
		return $this->connection()->hexists($this->prefix.$name, $key);
	}

	public function getAllArrayValues($name)
	{
		return $this->connection()->hgetall($this->prefix.$name);
	}

	public function exists($name)
	{
		return $this->connection()->exists($this->prefix.$name);
	}
}