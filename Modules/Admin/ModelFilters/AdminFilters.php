<?php

namespace Modules\Admin\ModelFilters;

use EloquentFilter\ModelFilter;

class AdminFilters extends ModelFilter
{
    public function name($name): AdminFilters
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    public function email($email): AdminFilters
    {
        return $this->where('name', 'like', '%' . $email . '%');
    }
}
