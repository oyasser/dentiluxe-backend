<?php

namespace Modules\PromoCode\Exceptions;

use InvalidArgumentException;

class PromocodeIsLessThanMinQty extends InvalidArgumentException
{
    /**
     * @param  $user
     * @param string $code
     * @return void
     */
    public function __construct(string $code)
    {
        parent::__construct("The given code `{$code}` is already less than the minimum order quantity.");
    }
}
