<?php

namespace Modules\Price\Models;

use App\Traits\Paginatable;
use App\Traits\Localization;
use Modules\Item\Models\Item;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Price\ModelFilters\PriceFilters;
use Modules\Price\Database\factories\PriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Price extends Model
{
    use HasFactory;
    use Filterable;
    use Paginatable;
    use Sluggable;
    use Localization;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'status',
    ];

    protected $casts = [
        'status'     => 'bool',
        'is_default' => 'bool',
    ];

    protected static function newFactory(): PriceFactory
    {
        return PriceFactory::new();
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(PriceFilters::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeNotActive($query)
    {
        return $query->where('status', 0);
    }
}
