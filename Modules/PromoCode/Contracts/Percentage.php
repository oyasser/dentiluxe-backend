<?php

namespace Modules\PromoCode\Contracts;

class Percentage extends PromoCodeContract
{
    public function calculateDiscount(): float|int
    {
        $this->setTotal();
        $this->validateTotalGreaterThanMinimumOrder();

        $discount = ($this->getTotal() * $this->promoCode->discount_value) / 100;

        return min($discount, $this->promoCode->maximum_discount);
    }
}
