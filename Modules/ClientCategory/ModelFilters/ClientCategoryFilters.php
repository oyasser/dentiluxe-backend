<?php

namespace Modules\ClientCategory\ModelFilters;

use EloquentFilter\ModelFilter;

class ClientCategoryFilters extends ModelFilter
{
    public function name($name): ClientCategoryFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }
}
