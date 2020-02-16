<?php

namespace App\Contracts\Cache;

interface Cacheable 
{
	public static function getCachePrefix();
	public function buildFromCache(array $data, $cache = null);
}