<?php

namespace Modules\PromoCode\Contracts;

use Modules\PromoCode\Exceptions\PromocodeIsLessThanMinQty;

class FreeAddon extends PromoCodeContract
{
    public function calculateDiscount(): float|int
    {
        $itemsAcceptedPromoCode = $this->getItemsAcceptPromoCode();

        $MinimumQty = $this->promoCode->minimum_order;
        $discountQty = $this->promoCode->discount_value;

        $totalDiscount = 0;

        if ($itemsAcceptedPromoCode->count()) {
            foreach ($itemsAcceptedPromoCode as $item) {
                $cartQty = $item->pivot->qty;

                $numberOfOffers = floor($cartQty / ($MinimumQty + $discountQty));
                $freeItemsQty = $numberOfOffers * $discountQty;

                if ($freeItemsQty) {
                    $totalDiscount += $freeItemsQty * $item->salesPrice;
                }

            }
        }

        return $totalDiscount ?: throw new PromocodeIsLessThanMinQty($this->promoCode->code);
    }
}
