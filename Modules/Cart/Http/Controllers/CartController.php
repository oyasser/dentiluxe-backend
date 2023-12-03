<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Cart\Http\Requests\StoreCartRequest;
use Modules\Cart\Services\CartService;
use Modules\Cart\Transformers\CartResource;

class CartController extends Controller
{
    public CartService $service;

    /**
     * Create a new repository instance.
     * @param CartService $service
     * @return void
     */
    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCartRequest $request
     * @return JsonResponse|CartResource
     */
    public function store(StoreCartRequest $request): JsonResponse|CartResource
    {
        $cart = $this->service->addToCart($request->validated());

        return $cart ? new CartResource($cart) : $this->returnBadRequest();
    }

    /**
     * @return CartResource|JsonResponse
     */
    public function show(): CartResource|JsonResponse
    {
        $cartContent = $this->service->getContent();

        return $cartContent ? new CartResource($cartContent) : $this->returnSuccess(trans('cart::messages.empty-error'), ['items' => []]);
    }

    /**
     * @param $item
     * @return JsonResponse
     */
    public function remove($item): JsonResponse
    {
        return $this->service->removeFromCart($item) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        return $this->service->clear() ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
