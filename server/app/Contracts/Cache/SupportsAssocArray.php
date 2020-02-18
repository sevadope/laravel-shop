<?php

namespace App\Contracts\Cache;

interface SupportsAssocArray 
{
	/**
	 * Get value from associative array by key
	 **/
	public function getArrayValue($name, $key);
	
	/**
	 * Get many values from associative array
	 **/
	public function getArrayValues($name, array $keys);

	/**
	 * Put value to associative array
	 **/
	public function putArrayValue($name, $key, $value);

	/**
	 * Put many values to associative array
	 **/
	public function putArrayValues($name, array $values);

	/**
	 * Get array length
	 **/
	public function getArrayLength($name);

	/**
	 * Check if array contains value by key
	 **/
	public function arrayValueExists($name, $key);

	/**
	 * Check if key exists
	 **/
	public function exists($key);
}	