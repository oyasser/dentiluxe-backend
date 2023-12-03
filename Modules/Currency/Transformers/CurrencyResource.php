<?php

namespace Modules\Currency\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name' => $this->name,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'slug'       => $this->slug,
            'rate'       => $this->rate,
            'status'     => $this->status,
            'is_default' => $this->is_default,
        ];
    }
}
