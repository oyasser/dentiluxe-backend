<?php

namespace Modules\PromoCode\Exceptions;

use InvalidArgumentException;

class PromocodeExpiredException extends InvalidArgumentException
{
    /**
     * @param string|null $code
     */
    public function __construct(string $code = null)
    {
        parent::__construct("The given code `{$code}` already expired.");
    }
}
