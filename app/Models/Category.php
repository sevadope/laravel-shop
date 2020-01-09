<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Relations\HasDescendants;
use App\Relations\HasChildren;
use App\Relations\HasAncestors;
use App\Contracts\NestedSetNode;

class Category extends Model implements NestedSetNode
{
    protected $fillable = [
    	'name',
    	'slug',
    	'description',
        'popularity',
        'left',
        'right',
    ];

    /*|==========| Relationships |==========|*/

    public function descendants()
    {
        return new HasDescendants($this->newQuery(), $this);
    }

    public function children()
    {
        return new HasChildren($this->newQuery(), $this);
    }

    public function ancestors()
    {
        return new HasAncestors($this->newQuery(), $this);
    }

    /*|==========| Scopes |==========|*/

    public function scopeOrderByPopularity($query)
    {
        return $query->orderBy('popularity');
    }
    
    public function scopeWhereSlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    /*|====================|*/

    public function hasChildren()
    {
        return $this->getTreeRightKey() - $this->getTreeLeftKey() !== 1;
    }

    public function hasNoChildren()
    {
        return $this->getTreeRightKey() - $this->getTreeLeftKey === 1;
    }

    public function getTreeLeftKey()
    {
        return $this->tree_left_key;
    }

    public function getTreeRightKey()
    {
        return $this->tree_right_key;
    }

    public function getTreeDepth()
    {
        return $this->tree_depth;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
