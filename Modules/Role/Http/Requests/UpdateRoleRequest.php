<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|unique:roles,name,' . $this->role,
            'permissions' => 'sometimes|required|array',
            'permissions.*' => 'sometimes|required|int|exists:permissions,id',
        ];
    }
}
