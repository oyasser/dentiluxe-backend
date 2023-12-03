<?php

namespace Modules\Item\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Item\Models\Item;

class StoreItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:60|not_regex:/[ء-ي]+/|unique:items,name_en',
            'name_ar' => 'required|string|max:60|regex:/[ء-ي]+/|unique:items,name_ar',
            'description_en' => 'required|string|not_regex:/[ء-ي]+/',
            'description_ar' => 'required|string|regex:/[ء-ي]+/',
            'in_stock' => 'sometimes|required|boolean',
            'available_stock' => 'sometimes|required|int|min:1',
//            'min_stock' => Rule::requiredIf(function () {
//                return $this->type == 'ITEM';
//            }),
            'type' => 'required|in:ITEM,SIMPLE,MIXED',
            'items' => Rule::requiredIf(in_array($this->type, ['SIMPLE', 'MIXED'])),
            'barcode' => 'nullable|string|max:60',
            'sku' => 'nullable|string|max:60',
            'categories.*' => 'required|int|exists:categories,id',
            'tags.*' => 'required|int|exists:tags,id',
            'currency_id' => 'required|int|exists:currencies,id',
            'prices' => 'required|array',
            'prices.*.price_id' => 'required|int|exists:prices,id',
            'prices.*.price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'prices.*.client_category_id' => 'nullable',
            'prices.*.discount_price' => 'sometimes|required|regex:/^\d+(\.\d{1,2})?$/',
            'images' => 'required',
            'status' => 'sometimes|required|boolean',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'currency_id' => 1,
            'min_stock' => $this->has('min_stock') ? $this->min_stock : 0,
        ]);

        if ($this->type == 'SIMPLE' && count($this->items)) {
            $item = Item::find($this->items[0]['single_item_id']);

            $this->merge([
                'categories' => $item->categories->pluck('id')->toArray(),
                // 'currency_id' => $item->currency_id,
            ]);
        }
    }
}
