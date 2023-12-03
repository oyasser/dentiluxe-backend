<?php

namespace Modules\ClientCategory\Models;

use App\Traits\Paginatable;
use App\Traits\Localization;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientCategory\ModelFilters\ClientCategoryFilters;
use Modules\ClientCategory\Database\factories\ClientCategoryFactory;

class ClientCategory extends Model
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
        'is_default',
        'status',
    ];

    protected $casts = [
        'status'     => 'bool',
        'is_default' => 'bool',
    ];

    protected static function newFactory(): ClientCategoryFactory
    {
        return ClientCategoryFactory::new();
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(ClientCategoryFilters::class);
    }
}
