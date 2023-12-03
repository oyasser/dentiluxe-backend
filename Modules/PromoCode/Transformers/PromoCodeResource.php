<?php

namespace Modules\PromoCode\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\Transformers\ItemResource;

class PromoCodeResource extends JsonResource
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
            'code' => $this->code,
            'minimum_order' => $this->minimum_order,
            'maximum_discount' => $this->maximum_discount,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'multi_use' => $this->multi_use,
            'usages' => $this->usages == -1 ? null : $this->usages,
            'unlimited' => $this->usages == -1,
            'bound_to_user' => $this->bound_to_user,
            'expired_at' => $this->expired_at,
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
