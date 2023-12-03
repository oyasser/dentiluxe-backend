<?php

namespace Modules\Item\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\CategoryResource;
use Modules\Image\Transformers\ImageResource;
use Modules\Price\Transformers\PriceResource;
use Modules\Tag\Transformers\TagResource;

class ItemResource extends JsonResource
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
            'in_stock' => $this->in_stock,
            'available_stock' => $this->available_stock,
            'trending' => $this->trending,
            'best_seller' => $this->best_seller,
            'is_favorited' => (bool)$this->whenLoaded('favorites', count($this->favorites), false),

            'status' => $this->status,

            'images' => ImageResource::collection($this->whenLoaded('images')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'prices' => PriceResource::collection($this->whenLoaded('prices')),
            'bundleItems' => ItemResource::collection($this->whenLoaded('bundleItems')),

            'qty' => $this->whenPivotLoaded('bundle_items', fn() => $this->pivot->qty),

            'cart_price' => $this->whenPivotLoaded('cart_item', fn() => $this->pivot->price),
            'cart_qty' => $this->whenPivotLoaded('cart_item', fn() => $this->pivot->qty),

            'sales_order_price' => $this->whenPivotLoaded('item_sales_order', fn() => $this->pivot->price),
            'sales_order_qty' => $this->whenPivotLoaded('item_sales_order', fn() => $this->pivot->qty),

        ];
    }
}
