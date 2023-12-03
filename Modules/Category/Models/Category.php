<?php

namespace Modules\Category\Models;

use App\Scopes\ActiveScope;
use App\Traits\Imageable;
use App\Traits\Localization;
use App\Traits\Paginatable;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Category\Database\factories\CategoryFactory;
use Modules\Category\ModelFilters\CategoryFilters;
use Modules\Item\Models\Item;

class Category extends Model
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
        'parent_id',
        'has_sub',
        'featured',
        'menu',
        'status',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'status' => 'boolean',
        'has_sub' => 'boolean',
        'featured' => 'boolean',
        'menu' => 'boolean',
    ];

//    protected $with = ['image'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(CategoryFilters::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function allSubCategories(): HasMany
    {
        return $this->sub()->with('allSubCategories');
    }

    public function sub(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    public function limitItems($limit = 6): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->limit($limit);
    }


    public function getPatentsId(): array
    {
        $parents = [];

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents[] = $parent->id;
            $parent = $parent->parent;
        }

        return array_reverse($parents);
    }
}
