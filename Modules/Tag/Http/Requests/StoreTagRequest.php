<?php

namespace Modules\Tag\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|string|max:60|not_regex:/[ء-ي]+/',
            'name_ar' => 'required|string|max:60|regex:/[ء-ي]+/',
            'status' => 'sometimes|required|boolean',
        ];
    }
}
