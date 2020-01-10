<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class HasSpecifications extends Relation
{
	protected $spec;
	protected $spec_value;
	protected $spec_foreign_key;
	protected $parent_foreign_key;

	public function __construct(
		Builder $query,
		Model $parent,
		string $spec_model,
		string $spec_value_model,
		string $parent_foreign_key,
		string $spec_foreign_key = 'specification_id'
	) 
	{
		$this->spec = new $spec_model;
		$this->spec_value = new $spec_value_model;
		$this->spec_foreign_key = $spec_foreign_key;
		$this->parent_foreign_key = $parent_foreign_key;

		parent::__construct($query, $parent);
	}

	public function addConstraints()
	{
		$this->performJoin();

		if (static::$constraints) {
			$this->query->where(
				$this->getFullParentForeignKey(),
				'=',
				$this->parent->getKey()
			);
		}
	}

	public function addEagerConstraints(array $models)
	{
		$this->query->whereIn(
			$this->getFullParentForeignKey(),
			array_map(function ($model) {
				return $model->getKey();
			}, $models)
		);
	}
	
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

	public function match(array $models, Collection $results, $relation)
	{
		$dictionary = [];
		
		foreach ($results as $result) {
			$dictionary[$result->{$this->parent_foreign_key}][] = $result;
		}

		foreach ($models as $model) {
			$model->setRelation(
				$relation,
				$this->related->newCollection($dictionary[$model->getKey()])
			);
		}

		return $models;
	}

    public function getResults()
    {
        return ! is_null($this->parent->getKey())
                ? $this->query->get()
                : $this->related->newCollection();
    }

	protected function performJoin()
	{
		$this->query->join(
			$this->spec_value->getTable(),
			$this->getFullSpecificationKey(),
			$this->getFullSpecForeignKey()
		);
	}

	protected function getFullSpecificationKey()
	{
		return $this->spec->getTable() . '.' . $this->spec->getKeyName();
	}

	protected function getFullSpecForeignKey()
	{
		return $this->spec_value->getTable() . '.' . $this->spec_foreign_key;
	}

	protected function getFullParentForeignKey()
	{	
		return $this->spec_value->getTable() . '.' . $this->parent_foreign_key;
	}
}