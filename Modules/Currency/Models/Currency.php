<?php

namespace Modules\Currency\Models;

use App\Traits\Paginatable;
use App\Traits\Localization;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Currency\ModelFilters\CurrencyFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Currency\Database\factories\CurrencyFactory;

class Currency extends Model
{
    use HasFactory;
    use Filterable;
    use Paginatable;
    use Sluggable;
    use Localization;

    protected $fillable = [
        'name_en',
        'name_ar',
        'rate',
        'is_default',
        'status',
    ];

    protected $casts = [
        'status'     => 'bool',
        'is_default' => 'bool',
    ];

    protected static function newFactory(): CurrencyFactory
    {
        return CurrencyFactory::new();
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(CurrencyFilters::class);
    }
}
