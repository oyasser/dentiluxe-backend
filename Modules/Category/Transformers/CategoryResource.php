<?php

namespace Modules\Category\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Image\Transformers\ImageResource;
use Modules\Item\Transformers\ItemResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'slug' => $this->slug,
            'description' => $this->description,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'status' => $this->status,
            'parent_id' => $this->parent_id,
            'has_sub' => $this->has_sub,
            'image' => new ImageResource($this->whenLoaded('image')),
            'categories_ids' => $this->when($this->categories_ids, $this->categories_ids),
            'sub_categories' => CategoryResource::collection($this->whenLoaded('allSubCategories')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
