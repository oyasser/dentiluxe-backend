<?php

namespace Modules\SalesOrder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\PromoCode\Exceptions\PromocodeAlreadyUsedByUserException;
use Modules\PromoCode\Exceptions\PromocodeBoundToOtherUserException;
use Modules\PromoCode\Exceptions\PromocodeDoesNotExistException;
use Modules\PromoCode\Exceptions\PromocodeExpiredException;
use Modules\PromoCode\Exceptions\PromocodeNoUsagesLeftException;
use Modules\PromoCode\Models\Promocode;

class StoreSalesOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'details' => 'required',
            'details.name' => 'required|string',
            'details.phone' => 'required',
            'details.shipping' => 'required|string',
            'code' => 'sometimes|required|string',
            'promo_code' => 'boolean',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'promo_code' => $this->has('code') && $this->validateCode($this->code),
        ]);
    }

    public function validateCode($code): bool
    {
        $user = auth()->user();

        $promoCode = Promocode::where('code', $code)->first();

        if (!$promoCode) {
            throw new PromocodeDoesNotExistException($code);
        }

        if ($promoCode->isExpired()) {
            throw new PromocodeExpiredException($code);
        }

        if (!$promoCode->hasUsagesLeft()) {
            throw new PromocodeNoUsagesLeftException($code);
        }

        if ($user) {
            if (!$promoCode->allowedForUser($user)) {
                throw new PromocodeBoundToOtherUserException($user, $code);
            }

            if (!$promoCode->multi_use && $promoCode->appliedByUser($user)) {
                throw new PromocodeAlreadyUsedByUserException($user, $code);
            }
        }

        return true;
    }
}
