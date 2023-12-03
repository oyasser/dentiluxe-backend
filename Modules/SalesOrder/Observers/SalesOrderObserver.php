<?php

namespace Modules\SalesOrder\Observers;

use Illuminate\Support\Str;
use Modules\SalesOrder\Events\OrderCreated;
use Modules\SalesOrder\Models\SalesOrder;

class SalesOrderObserver
{
    /**
     *
     * @param SalesOrder $salesOrder
     * @return void
     */
    public function creating(SalesOrder $salesOrder): void
    {
        $salesOrder->order_number = rand(1, 20) . Str::random(10);
    }

    /**
     *
     * @param SalesOrder $salesOrder
     * @return void
     */
    public function updated(SalesOrder $salesOrder): void
    {
        OrderCreated::dispatchIf($salesOrder->status == 'COMPLETED', $salesOrder);
    }
}
