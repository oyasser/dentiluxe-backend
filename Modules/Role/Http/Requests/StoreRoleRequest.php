<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|string|unique:roles,name',
            'permissions'   => 'required|array',
            'permissions.*' => 'required|int|exists:permissions,id',
        ];
    }
}

