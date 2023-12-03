<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required' ,
                'min:6',
                'max:10',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        $fail('Incorrect password, it does not match the current password.');
                    }
                },
            ],
            'password' => [
                'required',
                'min:6',
                'max:10',
                'string',
                'confirmed',
                'different:current_password',
            ],
        ];
    }
}
