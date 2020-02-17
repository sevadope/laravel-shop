<?php

namespace App\Concerns;

trait CanCacheActions 
{
	abstract protected function getCachedActions();

	public function cached(string $action)
	{
		return in_array($action, $this->getCachedActions());
	}
}