<?php

namespace Modules\PromoCode\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Modules\Item\Models\Item;
use Modules\SalesOrder\Models\SalesOrder;

class Promocode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'code',
        'minimum_order',
        'maximum_discount',
        'discount_type',
        'discount_value',
        'multi_use',
        'usages',
        'bound_to_user',
        'user_id',
        'expired_at',
    ];

    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
        'maximum_discount' => 'float',
        'usages' => 'integer',
        'bound_to_user' => 'boolean',
        'multi_use' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'promocode_redemptions')->withPivot('created_at');
    }

    /**
     * @return BelongsTo
     */
    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    /**
     * @return BelongsToMany
     */
    public function salesOrders(): BelongsToMany
    {
        return $this->belongsToMany(SalesOrder::class, 'promocode_redemption');
    }

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_promocode');
    }

    /**
     * @param Builder $builder
     * @return void
     */
    public function scopeAvailable(Builder $builder): void
    {
        $builder->whereNull('expired_at')->orWhere('expired_at', '>', now());
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at->isBefore(now());
    }

    /**
     * @return bool
     */
    public function isUnlimited(): bool
    {
        return $this->usages === -1;
    }

    /**
     * @return bool
     */
    public function hasUsagesLeft(): bool
    {
        return $this->isUnlimited() || $this->usages > 0;
    }

    /**
     * @param  $user
     * @return bool
     */
    public function allowedForUser($user): bool
    {
        return !$this->bound_to_user || $this->user === null || $this->user->is($user);
    }

    /**
     * @param $user
     * @return bool
     */
    public function appliedByUser($user): bool
    {
        return $this->users()->where(DB::raw('users.id'), $user->id)->exists();
    }

    /**
     * @param string $key
     * @param mixed|null $fallback
     * @return mixed
     */
    public function getDetail(string $key, mixed $fallback = null): mixed
    {
        return $this->details[$key] ?? $fallback;
    }
}
