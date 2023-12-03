<?php

namespace Modules\Currency\ModelFilters;

use EloquentFilter\ModelFilter;

class CurrencyFilters extends ModelFilter
{
    public function name($name): CurrencyFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }
}
