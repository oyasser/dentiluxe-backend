<?php

namespace Modules\PromoCode\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\PromoCode\Http\Requests\IndexPromoCodeRequest;
use Modules\PromoCode\Http\Requests\StorePromoCodeRequest;
use Modules\PromoCode\Http\Requests\UpdatePromoCodeRequest;
use Modules\PromoCode\Services\PromoCodeService;
use Modules\PromoCode\Transformers\PromoCodeResource;

class PromoCodeController extends Controller
{
    private PromoCodeService $service;

    /**
     * Create a new repository instance.
     * @param PromoCodeService $service
     * @return void
     */
    public function __construct(PromoCodeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @param IndexPromoCodeRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexPromoCodeRequest $request): AnonymousResourceCollection
    {
        $promoCodes = $this->service->all($request->validated());

        return PromoCodeResource::collection($promoCodes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePromoCodeRequest $request
     * @return JsonResponse
     */
    public function store(StorePromoCodeRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return PromoCodeResource
     */
    public function show($slug): PromoCodeResource
    {
        $promoCode = $this->service->find($slug);

        return new PromoCodeResource($promoCode);
    }

    /**
     * Update the resource values.
     *
     * @param UpdatePromoCodeRequest $request
     * @param $code
     * @return JsonResponse
     */
    public function update(UpdatePromoCodeRequest $request, $code): JsonResponse
    {
        return $this->service->update($code, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Expire the resource value.
     *
     * @param $code
     * @return JsonResponse
     */
    public function expire($code): JsonResponse
    {
        return $this->service->expirePromoCode($code) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Update the resource status value.
     *
     * @param $code
     * @return JsonResponse
     */
    public function discount($code): JsonResponse
    {
        $discount = $this->service->calculateDiscount($code);
        return $discount ? $this->returnSuccess('success', ['value' => $discount]) : $this->returnBadRequest();
    }
}
