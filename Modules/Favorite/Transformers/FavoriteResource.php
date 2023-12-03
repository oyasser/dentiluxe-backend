<?php

namespace Modules\Favorite\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $className = Str::of($this->favorited_type)->afterLast('\\');
        $resource = 'Modules\\' . $className . '\\Transformers\\' . $className . 'Resource';

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'favorited' => new $resource($this->favorited),
        ];
    }
}
