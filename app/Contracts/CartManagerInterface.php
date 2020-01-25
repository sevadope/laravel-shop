<?php

namespace App\Contracts;

interface CartManagerInterface 
{
	public function getPlain($name, $key);
	public function get($name, $key);
	public function set($name, $key, array $data);
}