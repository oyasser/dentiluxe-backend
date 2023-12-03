<?php

namespace Modules\Slider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
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
            'description_en' => 'nullable|string|not_regex:/[ء-ي]+/',
            'description_ar' => 'nullable|string|regex:/[ء-ي]+/',
            'url' => 'nullable|string',
            'image' => 'required|mimes:jpg,jpeg,bmp,png',
            'status' => 'sometimes|required|boolean',
        ];
    }
}
