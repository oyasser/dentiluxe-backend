<?php

namespace Modules\Currency\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Currency\Models\Currency;

class StoreCurrencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|string|max:60|not_regex:/[ء-ي]+/|unique:currencies,name_en',
            'name_ar' => 'required|string|max:60|regex:/[ء-ي]+/|unique:currencies,name_ar',
            'rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'is_default' => 'sometimes|required|boolean',
        ];
    }


    public function prepareForValidation()
    {
        if (!Currency::count()) {
            $this->merge([
                'rate' => 1,
                'is_default' => true,
            ]);
        }
    }
}
