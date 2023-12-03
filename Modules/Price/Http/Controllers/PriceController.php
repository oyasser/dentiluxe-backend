<?php

namespace Modules\Price\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Price\Services\PriceService;
use Modules\Price\Transformers\PriceResource;
use Modules\Price\Http\Requests\IndexPriceRequest;
use Modules\Price\Http\Requests\StorePriceRequest;
use Modules\Price\Http\Requests\UpdatePriceRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PriceController extends Controller
{
    public PriceService $service;

    /**
     * Create a new repository instance.
     * @param PriceService $service
     * @return void
     */
    public function __construct(PriceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexPriceRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexPriceRequest $request): AnonymousResourceCollection
    {
        $prices = $this->service->all($request->validated());

        return PriceResource::collection($prices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePriceRequest $request
     * @return JsonResponse
     */
    public function store(StorePriceRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return PriceResource
     */
    public function show($slug): PriceResource
    {
        $price = $this->service->find($slug);

        return new PriceResource($price);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdatePriceRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdatePriceRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest('Can not update default price');
    }
}
