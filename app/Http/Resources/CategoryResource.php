<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'popularity' => $this->image,
            'tree_right_key' => $this->tree_right_key,
            'tree_left_key' => $this->tree_left_key,
            'tree_depth' => $this->tree_depth,
            'descendants' => new CategoryCollection($this->descendants),
            'childs' => new CategoryCollection($this->descendants->where('tree_depth', $this->tree_depth + 1)),
            'ancestors' => new CategoryCollection($this->ancestors),
            'parent' => new CategoryCollection($this->ancestors->where('tree_depth', $this->tree_depth - 1)),
        ];
    }
}
