<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'popularity' => $this->popularity,
            'tree_depth' => $this->tree_depth,

            'products' => new ProductCollection($this->whenLoaded('products')),
            'ancestors' => new CategoryCollection($this->ancestors),
            'descendants' => new CategoryCollection($this->descendants),
            'children' => new CategoryCollection($this->children),
        ];
    }
}
