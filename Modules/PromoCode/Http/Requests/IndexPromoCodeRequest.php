<?php

namespace Modules\PromoCode\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPromoCodeRequest extends FormRequest
{
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
            'code' => ['string'],
            'sort' => ['string', 'in:code'],
            'direction' => ['string', 'in:asc,desc'],
        ];
    }
}
