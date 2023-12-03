<?php

namespace Modules\Image\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'url'  => $this->url,
            'main' => $this->main,
        ];
    }
}
