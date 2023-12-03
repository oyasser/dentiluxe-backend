<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Dashboard\Services\DashboardService;

class DashboardController extends Controller
{
    private DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function statistics(): array
    {
        return [
            'sales_details' =>  $this->service->orders(),
            'users_count' =>  $this->service->users(),
            'topFive'    => $this->service->topFiveItems(),
            'lowestFive' => $this->service->lowestFiveItems(),
            'sales'      => $this->service->salesChart(),
            'orders'     => $this->service->ordersChart(),
        ];
    }
}
