<?php

namespace Modules\PromoCode\Contracts;

class Fixed extends PromoCodeContract
{
    public function calculateDiscount(): float|int
    {
        $this->setTotal();

        $this->validateTotalGreaterThanMinimumOrder();

        return $this->promoCode->discount_value;
    }
}
