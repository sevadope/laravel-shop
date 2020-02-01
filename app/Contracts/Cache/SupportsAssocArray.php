<?php

namespace App\Contracts\Cache;

interface SupportsAssocArray 
{
	/**
	 * Get value from associative array by key
	 **/
	public function getArrayValue($name, $key);
	
	/**
	 * Put key with value to associative array
	 **/
	public function putArrayKey($name, $key, $value);
}