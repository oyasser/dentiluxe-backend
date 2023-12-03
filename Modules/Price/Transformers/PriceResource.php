<?php

namespace Modules\Price\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'status' => $this->status,
            'is_default' => $this->is_default,
            'description' => $this->description,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,

            //when loading prices relation
            'price' => $this->whenPivotLoaded('item_price', fn() => $this->pivot->price),
            'discount_price' => $this->whenPivotLoaded('item_price', fn() => $this->pivot->discount_price),
        ];
    }
}
