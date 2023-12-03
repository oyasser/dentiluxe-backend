<?php

namespace Modules\Blog\Models;

use App\Scopes\ActiveScope;
use App\Traits\Imageable;
use App\Traits\Localization;
use App\Traits\Paginatable;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\ModelFilters\BlogFilters;

class Blog extends Model
{
    use HasFactory;
    use Filterable;
    use Paginatable;
    use Sluggable;
    use Localization;
    use Imageable;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'status',
    ];

    protected $casts = [
        'status' => 'bool',
    ];

    protected $with = ['image'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(BlogFilters::class);
    }
}
