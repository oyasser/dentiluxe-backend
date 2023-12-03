<?php

namespace Modules\SalesOrder\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\Transformers\ItemResource;
use Modules\PromoCode\Transformers\PromoCodeResource;

class SalesOrderDetailsResource extends JsonResource
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
            'qty' => $this->qty,
            'price' => $this->price,
            'item' => new ItemResource($this->item),
            'promocode' => new PromoCodeResource($this->promocode),
        ];
    }
}
