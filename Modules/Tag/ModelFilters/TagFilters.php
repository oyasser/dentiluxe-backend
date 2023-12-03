<?php

namespace Modules\Tag\ModelFilters;

use EloquentFilter\ModelFilter;

class TagFilters extends ModelFilter
{
    public function name($name): TagFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }
}
