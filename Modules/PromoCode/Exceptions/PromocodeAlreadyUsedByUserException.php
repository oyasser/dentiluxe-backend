<?php

namespace Modules\PromoCode\Exceptions;

use InvalidArgumentException;

class PromocodeAlreadyUsedByUserException extends InvalidArgumentException
{
    /**
     * @param  $user
     * @param string|null $code
     */
    public function __construct($user, string $code = null)
    {
        parent::__construct("The given code `{$code}` is already used by user with id {$user->id}.");
    }
}
