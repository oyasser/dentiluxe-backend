<?php

namespace Modules\Slider\ModelFilters;

use EloquentFilter\ModelFilter;

class SliderFilters extends ModelFilter
{
    public function name($name): SliderFilters
    {
        return $this->where('name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }
}
