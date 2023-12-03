<?php

namespace Modules\PromoCode\ModelFilters;

use EloquentFilter\ModelFilter;

class PromoCodeFilters extends ModelFilter
{
    public function name($name): ItemFilters
    {
        return $this->where('items.name_' . app()->getLocale(), 'like', '%' . $name . '%');
    }

    public function barcode($barcode): ItemFilters
    {
        return $this->where('items.barcode', 'like', '%' . $barcode . '%');
    }

    public function sku($sku): ItemFilters
    {
        return $this->where('items.sku', 'like', '%' . $sku . '%');
    }

    public function type($type): ItemFilters
    {
        return $this->where('items.type', $type);
    }

    public function status(string $status): ItemFilters
    {
        return $this->where('status', $status == 'true' ? 1 : 0);
    }

    public function trending($trending): ItemFilters
    {

        return $this->where('trending', $trending);
    }

    public function bestSeller($bestSeller): ItemFilters
    {
        return $this->where('best_seller', $bestSeller);
    }
}
