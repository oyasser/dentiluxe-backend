<?php

namespace Modules\User\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Cart\Models\Cart;
use Modules\Favorite\Models\Favorite;
use Modules\PromoCode\Models\Promocode;
use Modules\SalesOrder\Models\SalesOrder;
use Modules\User\ModelFilters\UserFilters;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Filterable;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public function modelFilter(): ?string
    {
        return $this->provideFilter(UserFilters::class);
    }

    public function findForPassport($phone)
    {
        $phoneColumn = filter_var($phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return $this->where($phoneColumn, $phone)->first();
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * @return BelongsToMany
     */
    public function promocodes(): BelongsToMany
    {
        return $this->belongsToMany(Promocode::class, 'promocode_redemptions', 'user_id', 'promocode_id')->withPivot('created_at', 'sales_order_id');
    }

    /**
     * @return HasMany
     */
    public function boundPromocodes(): HasMany
    {
        return $this->hasMany(Promocode::class, 'user_id');
    }
}
