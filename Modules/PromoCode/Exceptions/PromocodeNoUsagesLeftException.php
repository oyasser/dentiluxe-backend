<?php

namespace Modules\PromoCode\Exceptions;

use InvalidArgumentException;

class PromocodeNoUsagesLeftException extends InvalidArgumentException
{
    /**
     * @param string|null $code
     */
    public function __construct(string $code = null)
    {
        parent::__construct("The given code `{$code}` has no usages left.");
    }
}
