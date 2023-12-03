<?php

namespace Modules\Item\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:60|not_regex:/[ء-ي]+/|unique:items,name_en,' . $this->id,
            'name_ar' => 'sometimes|required|string|max:60|regex:/[ء-ي]+/|unique:items,name_ar,' . $this->id,
            'description_en' => 'sometimes|required|string|not_regex:/[ء-ي]+/',
            'description_ar' => 'sometimes|required|string|regex:/[ء-ي]+/',
            'in_stock' => 'sometimes|required|boolean',
            'available_stock' => 'sometimes|required|int|min:1',
            //'min_stock' => 'sometimes|required|int|min:1',
            'barcode' => 'nullable|string|max:60',
            'sku' => 'nullable|string|max:60',
            'type' => 'sometimes|required|in:ITEM,SIMPLE,MIXED',
            'items' => 'sometimes|required|array',
            'categories.*' => 'sometimes|required|int|exists:categories,id',
            'tags.*' => 'sometimes|required|int|exists:tags,id',
            'currency_id' => 'sometimes|required|int|exists:currencies,id',
            'prices' => 'sometimes|required|array',
            'prices.*.price_id' => 'sometimes|required|int|exists:prices,id',
            'prices.*.price' => 'sometimes|required|regex:/^\d+(\.\d{1,2})?$/',
            'prices.*.client_category_id' => 'nullable',
            'prices.*.discount_price' => 'sometimes|required|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'sometimes|required|mimes:jpg,jpeg,bmp,png',
            'status' => 'sometimes|required|boolean',
            'trending' => 'sometimes|required|boolean',
            'best_seller' => 'sometimes|required|boolean',
        ];
    }
}
