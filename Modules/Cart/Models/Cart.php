<?php

namespace Modules\Cart\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Cart\Database\factories\CartFactory;
use Modules\Item\Models\Item;

class Cart extends Model
{
    use HasFactory;
    use Paginatable;

    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'session_id'
    ];

    protected static function newFactory(): CartFactory
    {
        return CartFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('price', 'qty');
    }
}
