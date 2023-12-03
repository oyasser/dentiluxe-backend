<?php

namespace Modules\Slider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
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
            'description_en' => 'sometimes|required|string|not_regex:/[ء-ي]+/',
            'description_ar' => 'sometimes|required|string|regex:/[ء-ي]+/',
            'url' => 'nullable|string',
            'image' => 'sometimes|required|mimes:jpg,jpeg,bmp,png',
            'status' => 'sometimes|required|boolean',
        ];
    }
}
