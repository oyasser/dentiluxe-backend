<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:60|not_regex:/[ء-ي]+/|unique:categories,name_en',
            'name_ar' => 'required|string|max:60|regex:/[ء-ي]+/|unique:categories,name_ar',
            'description_en' => 'required|not_regex:/[ء-ي]+/|string',
            'description_ar' => 'required|regex:/[ء-ي]+/|string',
            'parent_id' => 'required',
            'has_sub' => 'required|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'parent_id' => $this->has('parent_id') ? $this->parent_id : 0,
            'has_sub' => $this->has('has_sub'),
        ]);
    }
}
