<?php

namespace Modules\ClientCategory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:60|not_regex:/[ء-ي]+/|unique:client_categories,name_en',
            'name_ar' => 'required|string|max:60|regex:/[ء-ي]+/|unique:client_categories,name_ar',
            'description_en' => 'required|not_regex:/[ء-ي]+/|string',
            'description_ar' => 'required|regex:/[ء-ي]+/|string',
            'status'     => 'required|boolean',
            'is_default' => 'required|boolean',
            'notes'      => 'nullable|string',
        ];
    }
}
