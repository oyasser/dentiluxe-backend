<?php

namespace Modules\SalesOrder\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\SalesOrder\Events\OrderCreated;
use Modules\SalesOrder\Listeners\RewardGiftPromoCode;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            RewardGiftPromoCode::class
        ]
    ];
}
