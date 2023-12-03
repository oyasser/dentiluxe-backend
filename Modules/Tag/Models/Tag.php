<?php

namespace Modules\Tag\Models;

use App\Traits\Localization;
use App\Traits\Paginatable;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Item\Models\Item;
use Modules\Tag\ModelFilters\TagFilters;

class Tag extends Model
{
    use HasFactory;
    use Filterable;
    use Paginatable;
    use Sluggable;
    use Localization;

    protected $fillable = [
        'name_en',
        'name_ar',
        'status',
    ];

    protected $casts = [
        'status' => 'bool',
    ];

    public function modelFilter(): ?string
    {
        return $this->provideFilter(TagFilters::class);
    }

    /**
     * Get all the items that are assigned this tag.
     */
    public function items(): MorphToMany
    {
        return $this->morphedByMany(Item::class, 'taggable');
    }
}
