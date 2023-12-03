<?php

namespace Modules\Blog\ModelFilters;

use EloquentFilter\ModelFilter;

class BlogFilters extends ModelFilter
{
    public function name($name): BlogFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }
}
