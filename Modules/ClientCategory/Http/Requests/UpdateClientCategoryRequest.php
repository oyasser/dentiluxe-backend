<?php

namespace Modules\ClientCategory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:60|not_regex:/[ء-ي]+/|unique:client_categories,name_en,' . $this->price->id,
            'name_ar' => 'sometimes|required|string|max:60|regex:/[ء-ي]+/|unique:client_categories,name_ar,' . $this->price->id,
            'description_en' => 'sometimes|required|not_regex:/[ء-ي]+/|string',
            'description_ar' => 'sometimes|required|regex:/[ء-ي]+/|string',
            'status' => 'sometimes|required|boolean',
            'is_default' => 'sometimes|required|boolean',
        ];
    }
}
