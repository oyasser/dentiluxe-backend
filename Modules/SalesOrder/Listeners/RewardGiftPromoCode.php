<?php

namespace Modules\SalesOrder\Listeners;

use Modules\SalesOrder\Events\OrderCreated;

class RewardGiftPromoCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderCreated $event
     * @return void
     */
    public function handle(OrderCreated $event): void
    {
        $total = $event->order->total;

        match ($total) {
            $total >= 100 => createPromocodes(user: auth()->user(), expiration: now()->addMonth(), details: ['type' => 'fixed', 'discount' => 25]),
            $total >= 200 => createPromocodes(user: auth()->user(), expiration: now()->addMonth(), details: ['type' => 'fixed', 'discount' => 50]),
            $total >= 300 => createPromocodes(user: auth()->user(), expiration: now()->addMonth(), details: ['type' => 'fixed', 'discount' => 75]),
            $total >= 400 => createPromocodes(user: auth()->user(), expiration: now()->addMonth(), details: ['type' => 'fixed', 'discount' => 100]),
            default => createPromocodes(user: auth()->user(), expiration: now()->addMonth(), details: ['type' => 'fixed', 'discount' => 10])
        };
    }
}
