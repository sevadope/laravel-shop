<?php

namespace App\Contracts;

interface NestedSetNode
{
	public function getTreeLeftKey();
	public function getTreeRightKey();
	public function getTreeDepth();
}