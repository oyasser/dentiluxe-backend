<?php

namespace Modules\Price\ModelFilters;

use EloquentFilter\ModelFilter;

class PriceFilters extends ModelFilter
{
    public function name($name): PriceFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }
}
