<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page'       => ['integer', 'min:0'],
            'per_page'   => ['integer', 'min:0'],
            'name'       => ['string'],
            'email'      => ['string'],
            'sort'       => ['string', 'in:name'],
            'direction'  => ['string', 'in:asc,desc'],
        ];
    }
}
