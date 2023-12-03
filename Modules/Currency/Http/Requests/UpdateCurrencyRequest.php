<?php

namespace Modules\Currency\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:60|not_regex:/[ء-ي]+/|unique:currencies,name_en,' . $this->currency->id,
            'name_ar' => 'sometimes|required|string|max:60|regex:/[ء-ي]+/|unique:currencies,name_ar,' . $this->currency->id,
            'rate' => 'sometimes|required|regex:/^\d+(\.\d{1,2})?$/',
            'is_default' => 'sometimes|required|boolean',
        ];
    }
}
