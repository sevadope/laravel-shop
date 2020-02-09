<?php

namespace App\Contracts\Cache;

/**
 * Score is a sorted in ascending order array with unique values and numeric keys
 **/
interface SupportsScores
{
	/**
	 * Set value with key
	 **/
	public function putScoreValue($name, int $key, $value);

	/**
	 * Set several values with keys
	 **/	
	public function putScoreValues($name, array $values);

	/**
	 * Get key by value
	 **/
	public function getScoreKey($name, $value);

	/**
	 * Get values by key
	 **/
	public function getScoreValues($name, int $key);

	/**
	 * Get values by key range
	 **/
	public function getScoreRange($name, int $min, int $max, bool $reverse = false);

	/**
	 * Get values by positions range
	 **/
	public function getScoreRankRange($name, int $min, int $max, bool $reverse = false);

	/**
	 * Get values from the top of score
	 **/
	public function getFirstScoreValues($name, int $amount);

	/**
	 * Get all values
	 **/
	public function getAllScoreValues($name);

	/**
	 * Get length of score
	 **/
	public function getScoreLength($name);
}