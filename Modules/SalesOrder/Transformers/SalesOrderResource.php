<?php

namespace Modules\SalesOrder\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\Transformers\ItemResource;

class SalesOrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'details' => $this->details,

            'items' => ItemResource::collection($this->whenLoaded('items', $this->items)),
        ];
    }
}
