<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class NestedSetRelation extends Relation
{
	protected $left_key;
	protected $right_key;
	protected $depth;

	public function __construct(
		Builder $query,
		Model $parent,
		string $left_key = 'tree_left_key', 
		string $right_key = 'tree_right_key',
		string $depth = 'tree_depth'
	)
	{
		$this->left_key = $left_key;
		$this->right_key = $right_key;
		$this->depth = $depth;

		parent::__construct($query, $parent);
	}

	public function initRelation(array $models, $relation)
	{
		foreach ($models as $model) {
			$model->setRelation($relation, $this->related->newCollection());
		}

		return $models;
	}

	public function getResults()
	{
        return ! is_null($this->parent->getKey())
                ? $this->query->get()
                : $this->related->newCollection();		
	}
	
	abstract public function addConstraints();
	abstract public function addEagerConstraints(array $models);
	abstract public function match(array $models, Collection $results, $relation);
}