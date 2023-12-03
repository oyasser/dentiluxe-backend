<?php

namespace Modules\Item\Models;

use App\Scopes\ActiveScope;
use App\Traits\Favoritable;
use App\Traits\Imageable;
use App\Traits\Localization;
use App\Traits\Paginatable;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Category\Models\Category;
use Modules\Currency\Models\Currency;
use Modules\Item\Database\factories\ItemFactory;
use Modules\Item\ModelFilters\ItemFilters;
use Modules\Price\Models\Price;
use Modules\Tag\Models\Tag;

class Item extends Model
{
    use HasFactory;
    use Filterable;
    use Paginatable;
    use Sluggable;
    use Localization;
    use Imageable;
    use Favoritable;

    public const BUNDLE_TYPES = [
        'SIMPLE',
        'MIXED',
    ];
    protected $perPage = 9;
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'currency_id',
        'type',
        'in_stock',
        'available_stock',
        'trending',
        'best_seller',
        'status',
    ];

    protected $casts = [
        'in_stock' => 'bool',
        'trending' => 'bool',
        'best_seller' => 'bool',
        'status' => 'bool',
    ];
    protected $with = ['images', 'tags', 'favorites'];

    protected $appends = ['name', 'slug', 'description'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }

    protected static function newFactory(): ItemFactory
    {
        return ItemFactory::new();
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(ItemFilters::class);
    }

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * To get one or more bundle that contain a single item
     * bundle_id => reference for item (MIX OR SIMPLE BUNDLE) in table items
     * @return BelongsToMany
     */
    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, BundleItem::class, 'single_item_id', 'bundle_id')
            ->withPivot('qty');
    }

    /**
     * Get all the tags for the item.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @param $requestedQty
     * @return bool
     */
    public function isRequestedAvailableStockQtyValid($requestedQty): bool
    {
        return $this->available_stock >= $requestedQty;
    }

    /**
     * @param $categories
     * @return array
     */
    public function updateCategories($categories): array
    {
        return $this->categories()->sync($categories);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function prices(): BelongsToMany
    {
        return $this->belongsToMany(Price::class)
            ->withPivot('price', 'discount_price', 'client_category_id');
    }


    /**
     * To get the single items that exist in a bundle
     * @return BelongsToMany
     */
    public function bundleItems(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, BundleItem::class, 'bundle_id', 'single_item_id')
            ->withPivot('qty');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        return $query->where('items.status', 1);
    }

    /**
     * Scope a query to join vehicles.
     */
    public function scopeOrderJoin(Builder $query): Builder
    {
        return $query->join('item_sales_order', 'items.id', '=', 'item_sales_order.item_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotActive($query): mixed
    {
        return $query->where('items.status', 0);
    }

    /**
     * @return Attribute
     */
    protected function isBundle(): Attribute
    {
        return Attribute::make(
            get: function () {
                return !!in_array($this->type, Item::BUNDLE_TYPES);
            },
        );
    }

    /**
     * @return Attribute
     */
    protected function salesPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                $price = $this->price()->first()->pivot;

                return $price->discount_price == 0 ? $price->price : $price->discount_price;
            },
        );
    }

    public function price($type = 'sales-price'): BelongsToMany
    {
        return $this->belongsToMany(Price::class)
            ->withPivot('price', 'discount_price', 'client_category_id')
            ->where('slug_en', $type);
    }
}
