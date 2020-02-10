<?php

namespace App\Relations\NestedSet;

use Illuminate\Database\Eloquent\Collection;

class HasDescendants extends NestedSetRelation
{
	public function addConstraints()
	{
		if (static::$constraints) {
			$this->query->where([
				[$this->left_key, '>', $this->parent->getTreeLeftKey()],
				[$this->right_key, '<', $this->parent->getTreeRightKey()],
			]);
		}
	}

	public function addEagerConstraints(array $models)
	{
		$wheres = [];

		array_walk($models, function ($model) use (&$wheres) {
				$wheres[] = [$this->left_key, '>', $model->getTreeLeftKey(), 'or'];
				$wheres[] = [$this->right_key, '<', $model->getTreeRightKey(), 'and'];
			}
		);

		$this->query->where($wheres);
	}

	public function match(array $models, Collection $results, $relation)
	{
		foreach ($models as $model) {
			$model->setRelation(
				$relation, 
				$results->filter(function ($result) use ($model) {
					return 
						$result->getTreeLeftKey() > $model->getTreeLeftKey()
							&&
						$result->getTreeRightKey() < $model->getTreeRightKey();
				})
			);
		}

		return $models;
	}
}