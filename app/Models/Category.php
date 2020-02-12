<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Relations\NestedSet\HasDescendants;
use App\Relations\NestedSet\HasChildren;
use App\Relations\NestedSet\HasAncestors;
use App\Contracts\NestedSetNode;
use App\Contracts\Cache\Cacheable;
use Serializable;

class Category extends Model implements NestedSetNode, Cacheable, Serializable
{
    public const CACHED_SCORE_NAME = 'categories:score';
    public const CACHED_LIST_NAME = 'categories:list';

    protected $fillable = [
        'id',
    	'name',
    	'slug',
    	'description',
        'popularity',
        'tree_depth',
        'tree_left_key',
        'tree_right_key',
        'image',
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

    public function getSlug()
    {
        return $this->getAttribute('slug');
    }

    public function hasDescendants()
    {
        return $this->getTreeRightKey() - $this->getTreeLeftKey() !== 1;
    }

    public function hasNoDescendants()
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

    public static function getCacheListName()
    {
        return 'categories';
    }

    /*|==========| Serialization |==========|*/
    
    public function serialize()
    {
        $data = [
            'attributes' => $this->getAttributes(),
            'relations' => $this->relations,
        ];

        return serialize($data);
    }

    public function unserialize($data)
    {
        $data = unserialize($data);

        $this->setRawAttributes($data['attributes']);
        $this->setRelations($data['relations']);
    }
}
