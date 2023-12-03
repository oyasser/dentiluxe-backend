<?php

namespace Modules\PromoCode\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Item\Models\Item;
use Modules\PromoCode\Exceptions\PromocodeIsLessThanMinimum;
use Modules\PromoCode\Exceptions\PromocodeIsLessThanMinPrice;

abstract class PromoCodeContract
{
    protected $cartItems;
    protected $promoCode;
    protected int|float $total = 0;

    public function __construct($cartItems, $promoCode)
    {
        $this->cartItems = $cartItems;
        $this->promoCode = $promoCode;
    }

    /**
     * @return float|int
     */
    protected function getTotal(): float|int
    {
        return $this->total;
    }

    protected abstract function calculateDiscount();

    protected function setTotal(): void
    {
        foreach ($this->getItemsAcceptPromoCode() as $item) {
            $this->total += $item->pivot->qty * $item->salesPrice;
        }
    }

    protected function getItemsAcceptPromoCode(): Collection
    {
        $cartItems = $this->cartItems;
        $promoCodeItems = $this->promoCode->items->count() ? $this->promoCode->items : Item::whereDoesntHave('categories', function (Builder $query) {
            $query->where('slug_en', 'like', 'fertilizer%');
        })->get();
        $items = collect([]);
        foreach ($cartItems as $item) {
            if ($promoCodeItems->contains('id', $item->id)) {
                $items->push($item);
            }
        }
        return $items;
    }

    /**
     * @return void
     */
    protected function validateTotalGreaterThanMinimumOrder(): void
    {
        if ($this->total < $this->promoCode->minimum_order) {
            throw new PromocodeIsLessThanMinPrice($this->promoCode->code);
        }
    }
}
