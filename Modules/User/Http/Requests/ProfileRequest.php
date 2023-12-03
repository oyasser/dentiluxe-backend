<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:60',
            'email' => 'sometimes|required|email|unique:users,email,' . auth()->id(),
            'phone' => 'sometimes|required|string'
        ];
    }
}
