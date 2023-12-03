<?php

namespace Modules\Tag\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:60|not_regex:/[ء-ي]+/',
            'name_ar' => 'sometimes|required|string|max:60|regex:/[ء-ي]+/',
            'status' => 'sometimes|required|boolean',
        ];
    }
}
