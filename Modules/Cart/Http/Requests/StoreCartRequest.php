<?php

namespace Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable',
            'session_id' => 'required|string',
            'item_id' => 'required|int|exists:items,id',
            'qty' => 'required|int',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
            'session_id' => $this->header('session') ?? Str::random(40),
        ]);
    }
}
