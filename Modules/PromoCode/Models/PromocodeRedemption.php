<?php

namespace Modules\PromoCode\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PromocodeRedemption extends Pivot
{
    public $table = 'promocode_redemptions';

    protected $fillable = [
        'promocode_id',
        'user_id',
        'sales_order_id',
    ];
}
