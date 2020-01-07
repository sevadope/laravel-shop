<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'path',
    	'name',
    	'slug',
    	'description',
        'popularity',
    ];

    public function scopeOrderByPopularity($query)
    {
        return $query->orderBy('popularity');
    }

    public function descendants()
    {
        return $this->whereRaw($this->getPathColumn()." <@ '{$this->getPath()}'");
    }

    public function children()
    {
        return $this->whereRaw($this->getPathColumn()." ~ '{$this->getPath()}.*{1}'");
    }

    public function ancestors()
    {
        return $this->whereRaw($this->getPathColumn()." @> '{$this->getPath()}'");
    }

    public function getAllDescendants()
    {
        return $this->descendants()->get();
    }

    public function getAllAncestors()
    {
        return $this->ancestors()->get();
    }

    public function getAllChildren()
    {
        return $this->children()->get();
    }

    public function getPathColumn()
    {
        return 'path';
    }

    public function getPath()
    {
        return $this->{$this->getPathColumn()};
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
