<?php

namespace Modules\SalesOrder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\SalesOrder\Http\Requests\StoreSalesOrderRequest;
use Modules\SalesOrder\Http\Requests\UpdateSalesOrderRequest;
use Modules\SalesOrder\Services\SalesOrderService;
use Modules\SalesOrder\Transformers\SalesOrderResource;

class SalesOrderController extends Controller
{
    public SalesOrderService $service;

    /**
     * Create a new repository instance.
     * @param SalesOrderService $service
     * @return void
     */
    public function __construct(SalesOrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $salesOrders = $this->service->all(['sort' => 'created_at', 'direction' => 'desc']);

        return SalesOrderResource::collection($salesOrders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSalesOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreSalesOrderRequest $request): JsonResponse
    {
        $created = $this->service->create($request->validated());

        return $created ?
            $this->returnSuccess(trans('messages.create.success', ['module' => trans('salesorder::sales-orders.sales_order')])) :
            $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     * @param $order
     * @return SalesOrderResource
     */
    public function show($order): SalesOrderResource
    {
        $salesOrder = $this->service->find($order);

        return new SalesOrderResource($salesOrder);
    }

    /**
     * Update the resource value.
     * @param UpdateSalesOrderRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateSalesOrderRequest $request, $orderNUmber): JsonResponse
    {
        return $this->service->update($orderNUmber, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
