<?php

namespace Modules\ClientCategory\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
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
            'is_default' => $this->is_default,
        ];
    }
}
