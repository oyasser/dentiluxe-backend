<?php

namespace Modules\PromoCode\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePromoCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userIdValidation = $this->bound_to_user ? 'required|exists:users,id' : 'nullable';

        return [
            'code' => 'sometimes|required|string|unique:promocodes,code',
            'minimum_order' => 'sometimes|required|nullable|int',
            'maximum_discount' => 'sometimes|required|nullable|int',
            'discount_type' => 'sometimes|required|in:Fixed,Percentage,FreeAddon',
            'discount_value' => 'sometimes|required|string',
            'multi_use' => 'sometimes|required|boolean',
            'usages' => 'sometimes|required|int',
            'bound_to_user' => 'sometimes|required|boolean',
            'user_id' => $userIdValidation,
            'expired_at' => 'required|date',
            'items' => 'sometimes|required|nullable|array',
            'items.*' => 'required|int|exists:items,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'code' => $this->has('code') ? Str::upper($this->code) : Str::upper(Str::random(3) . '-' . Str::random(3)),
            'expired_at' => Carbon::createFromDate($this->expired_at),
            'usages' => $this->has('unlimited') ? -1 : $this->usages,
        ]);
    }
}
