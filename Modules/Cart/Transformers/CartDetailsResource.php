<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\Transformers\ItemResource;

class CartDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'qty' => $this->qty,
            'price' => $this->price,
            'item' => new ItemResource($this->item),
        ];
    }
}
