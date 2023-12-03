<?php

namespace Modules\PromoCode\Contracts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class PromoCodeFactory
{
    public static function make($cartItems, $promoCode)
    {
        $class = "Modules\\PromoCode\\Contracts\\" . Str::studly($promoCode->discount_type);

        if (!class_exists($class)) {
            throw new ModelNotFoundException();
        }

        return new $class($cartItems, $promoCode);
    }
}
