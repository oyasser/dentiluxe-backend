<?php

namespace Modules\SalesOrder\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Item\Models\Item;
use Modules\PromoCode\Models\Promocode;
use Modules\User\Models\User;

class SalesOrder extends Model
{
    use Filterable;

    protected $fillable = [
        'user_id',
        'sub_total',
        'discount',
        'total',
        'details',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'json',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('price', 'qty');
    }

    /**
     * @return BelongsToMany
     */
    public function promocode(): BelongsToMany
    {
        return $this->belongsToMany(Promocode::class, 'promocode_redemption');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
