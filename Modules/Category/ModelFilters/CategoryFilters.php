<?php

namespace Modules\Category\ModelFilters;

use EloquentFilter\ModelFilter;

class CategoryFilters extends ModelFilter
{
    public function name($name): CategoryFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }

    public function parentId($parentId): CategoryFilters
    {
        return $this->where('parent_id', $parentId);
    }
}
