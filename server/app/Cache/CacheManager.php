<?php

namespace App\Cache;

use Illuminate\Cache\CacheManager as Manager;
use App\Cache\RedisStore;
use Illuminate\Contracts\Foundation\Application;

class CacheManager extends Manager
{
	public function getDefaultDriver()
	{
		return 'redis';
	}

    /**
     * Create an instance of the Redis cache driver.
     *
     * @param  array  $config
     * @return \Illuminate\Cache\Repository
     */
    protected function createRedisDriver(array $config)
    {
        $redis = $this->app['redis'];

        $connection = $config['connection'] ?? 'default';

        return $this->repository(new RedisStore($redis, $this->getPrefix($config), $connection));
    }
}