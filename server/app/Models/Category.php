<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Relations\NestedSet\HasDescendants;
use App\Relations\NestedSet\HasChildren;
use App\Relations\NestedSet\HasAncestors;
use App\Contracts\NestedSetNode;
use App\Contracts\Cache\Cacheable;
use App\Cache\CacheManager;
use Illuminate\Database\Eloquent\Collection;
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
    
    public function scopeWhereRouteKey($query, $key)
    {
        return $query->where($this->getRouteKeyName(), $key);
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

    public static function getCachePrefix()
    {
        return 'category:';
    }

    public function buildFromCache(array $data, $cache = null)
    {
        $cache = $cache ?? resolve(CacheManager::class);

        $this->setRawAttributes(array_diff_key($data, ['relations' => 0]));

        if (array_key_exists('relations', $data)) {
            $rel_keys = unserialize($data['relations']);

            $relations = [];
            foreach ($rel_keys as $rel_name => $rel) {
                if (!empty($rel)) {
                    $values = $cache->getArrayValues(Category::CACHED_LIST_NAME, $rel);
                    $relations[$rel_name] = new Collection(array_map(function ($value) {
                        return unserialize($value);
                    }, $values));
                } else {
                    $relations[$rel_name] = new Collection; 
                }
            }       
            
            $this->setRelations($relations);     
        }
        
        return $this;
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
