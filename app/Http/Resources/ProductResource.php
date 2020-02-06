<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\OptionResource;
use App\Http\Resources\Product\SpecificationResource as SpecResource;

class ProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'popularity' => $this->popularity,
            'image' => $this->image,
            'price' => $this->price,
            'options' => OptionResource::collection($this->options),
            'specifications' => SpecResource::collection($this->specifications),
        ];
    }
}
