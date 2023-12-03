<?php

namespace Modules\SalesOrder\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\SalesOrder\Models\SalesOrder;

class OrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SalesOrder $salesOrder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SalesOrder $salesOrder)
    {
        $this->salesOrder = $salesOrder;
    }
}
