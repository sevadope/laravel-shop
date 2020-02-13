<?php

namespace App\Contracts\Cache;

interface Cacheable 
{
	public static function getCachePrefix();
}