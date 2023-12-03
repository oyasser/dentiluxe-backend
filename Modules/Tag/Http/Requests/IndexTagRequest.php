<?php

namespace Modules\Tag\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexTagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page'      => ['integer', 'min:0'],
            'per_page'  => ['integer', 'min:0'],
            'name'      => ['string'],
            'sort'      => ['string', 'in:name'],
            'direction' => ['string', 'in:asc,desc'],
        ];
    }
}
