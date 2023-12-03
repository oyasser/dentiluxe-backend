<?php

namespace Modules\Item\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => ['integer', 'min:0'],
            'per_page' => ['integer', 'min:0'],
            'name' => ['string'],
            'sort' => ['string', 'in:name'],
            'direction' => ['string', 'in:asc,desc'],
        ];
    }
}
