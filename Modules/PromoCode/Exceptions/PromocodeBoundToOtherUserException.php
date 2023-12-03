<?php

namespace Modules\PromoCode\Exceptions;

use InvalidArgumentException;

class PromocodeBoundToOtherUserException extends InvalidArgumentException
{
    /**
     * @param $user
     * @param string|null $code
     */
    public function __construct($user, string $code = null)
    {
        parent::__construct("The given code `{$code}` is bound to other user, not user with id {$user->id}.");
    }
}
