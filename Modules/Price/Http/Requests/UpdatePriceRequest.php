<?php

namespace Modules\Price\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'sometimes|required|string|max:60|not_regex:/[ء-ي]+/|unique:prices,name_en,' . $this->price->id,
            'name_ar' => 'sometimes|required|string|max:60|regex:/[ء-ي]+/|unique:prices,name_ar,' . $this->price->id,
            'description_en' => 'sometimes|required|string|not_regex:/[ء-ي]+/',
            'description_ar' => 'sometimes|required|string|regex:/[ء-ي]+/',
            'status' => 'sometimes|required|boolean',
        ];
    }
}
