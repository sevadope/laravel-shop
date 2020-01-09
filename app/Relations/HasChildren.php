<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Collection;

class HasChildren extends NestedSetRelation
{
	public function addConstraints()
	{
		if (static::$constraints) {
			$this->query->where([
				[$this->left_key, '>', $this->parent->getTreeLeftKey()],
				[$this->right_key, '<', $this->parent->getTreeRightKey()],
				[$this->depth, '=', $this->parent->getTreeDepth() + 1],
			]);
		}
	}

	public function addEagerConstraints(array $models)
	{
		$wheres = [];

		array_walk(
			$models,
			function ($item) use (&$wheres) {
				$wheres[] = [$this->left_key, '>', $item->getTreeLeftKey(), 'or'];
				$wheres[] = [$this->right_key, '<', $item->getTreeRightKey(), 'and'];
				$wheres[] = [$this->depth, '=', $item->getTreeDepth() + 1, 'and'];
			}
		);

		$this->query->where($wheres);
	}

	public function match(array $models, Collection $results, $relation)
	{
		foreach ($models as $model) {
			$model->setRelation($results, $models->filter(function ($result) use ($model) {
				return 
					$result->getTreeLeftKey() > $model->getTreeLeftKey()
						&&
					$result->getTreeRightKey() < $model->getTreeRightKey()
						&&
					$result->getTreeDepth() === $model->getTreeDepth() + 1;
			}));
		}

		return $models;
	}
}