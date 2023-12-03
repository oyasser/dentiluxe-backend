<?php

namespace Modules\User\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilters extends ModelFilter
{
    public function name($name): UserFilters
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    public function email($email): UserFilters
    {
        return $this->where('name', 'like', '%' . $email . '%');
    }
}
