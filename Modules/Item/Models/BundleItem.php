<?php

namespace Modules\Item\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Modules\Currency\Models\Currency;

class BundleItem extends Model
{
    protected $fillable = [
        'bundle_id',
        'single_item_id',
        'qty',
    ];

    public $timestamps = false;

    /**
     * Every bundle has a parent
     */
    public function bundleItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'bundle_id');
    }

    /**
     * Every bundle has children
     */
    public function singleItems(): HasMany
    {
        return $this->hasMany(Item::class, 'id', 'single_item_id');
    }
}
