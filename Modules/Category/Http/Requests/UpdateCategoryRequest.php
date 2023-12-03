<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:60|not_regex:/[ء-ي]+/|unique:categories,name_en,' . $this->id,
            'name_ar' => 'sometimes|required|string|max:60|regex:/[ء-ي]+/|unique:categories,name_ar,' . $this->id,
            'description_en' => 'sometimes|required|not_regex:/[ء-ي]+/|string',
            'description_ar' => 'sometimes|required|regex:/[ء-ي]+/|string',
            'parent_id' => 'sometimes|required',
            'has_sub' => 'sometimes|required|boolean',
            'status' => 'sometimes|required|boolean',
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
