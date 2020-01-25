<?php

namespace App\Contracts;

interface CartManagerInterface 
{
	public function get($name, $key);
	public function set($name, $key, array $data);
}