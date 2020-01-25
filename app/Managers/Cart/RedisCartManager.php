<?php

namespace App\Managers;

use App\Contracts\CartManagerInterface;
use \RedisManager;

class RedisCartManager implements CartManagerInterface
{
	public function get($name, $key)
	{	
		return ($res = RedisManager::command('hget', [$name, $key])) === false ?
			'[]' : $res;
	}

	public function set($name, $key, array $data)
	{
		return RedisManager::command('hset', [$name, $key, $data]);
	}
}