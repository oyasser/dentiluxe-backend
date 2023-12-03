<?php

namespace Modules\SalesOrder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:CONFIRMED,COMPLETED,CANCELED,REJECTED',
        ];
    }
}
