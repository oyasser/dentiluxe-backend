<?php

namespace Modules\Dashboard\Services;

use App\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Modules\Item\Repositories\Contracts\ItemRepository;
use Modules\User\Repositories\Contracts\UserRepository;
use Modules\SalesOrder\Repositories\Contracts\SalesOrderRepository;

class DashboardService extends Service
{
    private UserRepository $userRepository;
    private SalesOrderRepository $orderRepository;
    private ItemRepository $itemRepository;

    /**
     * Create a new service instance.
     */
    public function __construct(
        UserRepository       $userRepository,
        SalesOrderRepository $orderRepository,
        ItemRepository       $itemRepository
    ) {
        $this->userRepository  = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->itemRepository  = $itemRepository;
    }

    public function users(): array
    {
        $users   = [];
        $users[] = $this->userRepository->retrieve(['count(*) AS customers_count'])->first();
        $users[] = $this->orderRepository->retrieve(['count(if(user_id is null, 1, NULL)) as guests_count'])->first();

        return $users;
    }

    public function orders()
    {
        return $this->orderRepository->retrieveBy(['status' => 'COMPLETED'], ['ROUND(SUM(sub_total), 0) AS sub_total', 'ROUND(SUM(discount),0) AS total_discount', 'ROUND(SUM(total),0) AS total'])->first();
    }

    public function topFiveItems(): Collection
    {
        $joins   = ['OrderJoin'];
        $columns = ['name_en', 'name_ar', 'slug_en', 'slug_ar', 'SUM(item_sales_order.qty) as count'];
        $options = [
            'groupBy' => 'item_id',
            'limit'   => 5,
            'filters' => ['sort' => '@count', 'direction' => 'DESC'],
        ];

        return $this->itemRepository->retrieveJoined($joins, $columns, $options);
    }

    public function lowestFiveItems(): Collection
    {
        $joins   = ['OrderJoin'];
        $columns = ['name_en', 'name_ar', 'slug_en', 'slug_ar', 'SUM(item_sales_order.qty) as count'];
        $options = [
            'groupBy' => 'item_id',
            'limit'   => 5,
            'filters' => ['sort' => '@count', 'direction' => 'ASC'],
        ];

        return $this->itemRepository->retrieveJoined($joins, $columns, $options);
    }

    public function salesChart(): Collection
    {
        $columns = [
            DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            'COUNT(*) AS orders_count',
            'ROUND(SUM(sub_total), 0) as sub_total',
            'ROUND(SUM(discount), 0) as discount',
            'ROUND(SUM(total), 0) as total',
        ];

        $options = [
            'groupBy' => 'month',
            'filters' => ['sort' => '@month', 'direction' => 'ASC'],

        ];

        return $this->orderRepository->retrieveBy(['status' => 'COMPLETED'], $columns, $options);
    }

    public function ordersChart(): Collection
    {
        $columns = [
            'status',
            'COUNT(*) AS count',
        ];

        $options = [
            'groupBy' => 'status',
        ];

        return $this->orderRepository->retrieve($columns, $options);
    }
}
