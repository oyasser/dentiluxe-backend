<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Role\Transformers\RoleResource;

class AdminResource extends JsonResource
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
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
