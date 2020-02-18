<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class HasOptions extends Relation
{
	/**
	 * Option model instance
	 *
	 * @var  Model
	 **/
	protected $option;

	/**
	 * Primary key from options table
	 * 
	 * @var  string
	 **/
	protected $option_key;

	/**
	 * Foreign key from options values table references to options table
	 *
	 * @var string
	 **/
	protected $option_foreign_key;

	/**
	 * Pivot table for "Product <-> OptionValue" relationship
	 * 
	 * @var  string
	 **/
	protected $values_to_products_pivot_table;

	/**
	 * Foreign key from pivot table references to options values
	 * 
	 * @var  string
	 **/
	protected $pivot_value_key;

	/**
	 * Foreign key from pivot table references to products
	 * 
	 * @var  string
	 **/
	protected $pivot_product_key;

	/**
	 * Primary key of options values table
	 *
	 * @var  string
	 **/
	protected $local_key;

	/**
	 * The "name" of the relationship
	 *
	 * @var string
	 **/
	protected $relation;

	public function __construct(
		Builder $query,
		$parent,
		$option,

		$values_to_products_pivot_table,
		$pivot_value_key = 'value_id',
		$pivot_product_key = 'product_id',

		$local_key = 'id',
		$option_key = null,
		$option_foreign_key = 'option_id',
		$options_to_values_relation = 'values',
		$product_to_options_relation = 'options'
	)
	{
		$this->option = new $option;

		$this->values_to_products_pivot_table = $values_to_products_pivot_table;
		$this->pivot_value_key = $pivot_value_key;
		$this->pivot_product_key = $pivot_product_key;

		$this->local_key = $local_key;
		$this->option_key = $option_key ?? $this->option->getKeyName();
		$this->option_foreign_key = $option_foreign_key;
		$this->options_to_values_relation = $options_to_values_relation;
		$this->product_to_options_relation = $product_to_options_relation;

		parent::__construct($query, $parent);
	}

	public function addConstraints()
	{
		$this->query
			->join(
				$this->option->getTable(),
				$this->getFullOptionKeyName(),
				$this->getFullOptionForeignKeyName()
			)
			->join(
				$this->values_to_products_pivot_table,
				$this->getFullValueKeyName(),
				$this->getFullPivotValueForeignKeyName()
			);
			
		if (static::$constraints) {

			$this->query
				->where(
					$this->getFullPivotProductForeignKeyName(),
					$this->parent->getKey()
				);
		}
	}
	
	public function getResults()
	{
		$values = $this->query->get([$this->related->getTable() . '.*']);

		$opt_ids = [];
		$opt_values = [];

		foreach ($values as $value) {
			$cur_opt_id = $value->getAttribute($this->option_foreign_key);
			$opt_values[$cur_opt_id][] = $value;
			$opt_ids[] = $cur_opt_id;
		}

		$opt_ids = array_unique($opt_ids);

		$options = $this->option::whereIn($this->option_key, $opt_ids)->get();

		foreach ($options as $option) {
			$option->setRelation(
				$this->options_to_values_relation, 
				$opt_values[$option->getKey()]
			);
		}

		return $options;
	}

	public function addEagerConstraints(array $models)
	{
		$keys = [];

		foreach ($models as $model) {
			$keys[] = $model->getKey();
		}

		$this->query->whereIn($this->getFullPivotProductForeignKeyName(), $keys);
	}
	
	public function initRelation(array $models, $relation)
	{
		foreach ($models as $model) {
			$model->setRelation($relation, $this->related->newCollection());
		}

		return $models;
	}
	
	public function getEager()
	{
		return $this->get([
			$this->getFullPivotProductForeignKeyName(),
			$this->getFullOptionForeignKeyName(),
			$this->related->getTable().'.*',
		]);
	}

	public function match(array $models, Collection $results, $relation)
	{
		$op_fk = $this->option_foreign_key;
		$vals_rel = $this->options_to_values_relation;

		// Get all used options
		$opt_ids = array_unique($results->pluck($op_fk)->toArray());
		$opts = $this->option::whereIn($this->option_key, $opt_ids)->get();

		// Group values for products
		$p_values = $results
			->groupBy($this->pivot_product_key)
			->map(function ($coll) use ($opts, $op_fk, $vals_rel) {
				// Group values for every option
				return $coll
					->groupBy($op_fk)
					->map(function ($coll, $key) use ($opts, $vals_rel) {
						// Set values to their option
						return (clone $opts->find($key))->setRelation($vals_rel, $coll);
				});
		});

		foreach ($models as $model) {
			$model->setRelation(
				$this->product_to_options_relation,
				$p_values[$model->getKey()]
			);
		}

		return $models;
	}

	protected function getFullOptionKeyName()
	{
		return $this->option->getQualifiedKeyName();
	}

	protected function getFullOptionForeignKeyName()
	{
		return $this->related->getTable() . '.' . $this->option_foreign_key;
	}

	protected function getFullValueKeyName()
	{
		return $this->related->getTable() . '.' . $this->local_key;
	}

	protected function getFullPivotValueForeignKeyName()
	{
		return $this->values_to_products_pivot_table . '.' . $this->pivot_value_key;
	}

	protected function getFullPivotProductForeignKeyName()
	{
		return $this->values_to_products_pivot_table . '.' . $this->pivot_product_key;
	}
}