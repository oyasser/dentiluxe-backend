<?php

namespace Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCartRequest extends FormRequest
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
            'page'           => ['integer', 'min:1'],
            'perPage'        => ['integer', 'min:1', 'max:100'],
            'keyword'        => ['string', 'max:100'],
            //'name'           => ['string', 'max:100'],
        ];
    }
}
