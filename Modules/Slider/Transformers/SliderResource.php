<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Request;
use Modules\Image\Transformers\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'id'             => $this->id,
            'slug'           => $this->slug,
            'name'           => $this->name,
            'name_en'        => $this->name_en,
            'name_ar'        => $this->name_ar,
            'description'    => $this->description,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'url'            => $this->url,
            'status'         => $this->status,
            'image'          => new ImageResource($this->whenLoaded('image')),
        ];
    }
}
