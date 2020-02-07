<?php

namespace App\Cache;

use Illuminate\Cache\RedisStore as Store;
use App\Contracts\Cache\SupportsAssocArray;
use App\Contracts\Cache\SupportsScores;

class RedisStore extends Store implements SupportsAssocArray, SupportsScores
{
	/*|==========| Associative arrays |==========|*/

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

	/*|==========| Scores |==========|*/

	public function putScoreValue($name, int $key, $value)
	{
		return $this->connection()->zadd($this->prefix.$name, [$value => $key]);
	}

	public function putScoreValues($name, array $values)
	{
		return $this->connection()->zadd($this->prefix.$name, $values);
	}

	public function getScoreKey($name, $value)
	{
		return $this->connection()->zscore($this->prefix.$name, $value);
	}

	public function getScoreValues($name, int $key)
	{
		return $this
			->connection()
			->zrangebyscore($this->prefix.$name, $key, ++$key);
	}

	public function getScoreRange($name, int $min, int $max, bool $reverse = false)
	{
		$name = $this->prefix.$name;

		return $reverse ? 
			$this
				->connection()
				->zrevrangebyscore($name, $min, $max)
			: $this
				->connection()
				->zrangebyscore($name, $min, $max);
	}

	public function getAllScoreValues($name)	
	{
		return $this
			->connection()
			->zrange($this->prefix.$name, 0, -1, ['withscores' => true]);
	}

	public function getScoreLength($name)
	{
		return $this->connection()->zcard($this->prefix.$name);
	}

	public function exists($name)
	{
		return $this->connection()->exists($this->prefix.$name);
	}
}