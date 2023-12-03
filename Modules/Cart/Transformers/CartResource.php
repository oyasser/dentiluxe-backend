<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\Transformers\ItemResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'session' => $this->session_id,
            'items' => ItemResource::collection(($this->whenLoaded('items', $this->items))),
        ];
    }
}
