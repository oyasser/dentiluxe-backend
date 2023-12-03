<?php

namespace Modules\Currency\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Currency\Services\CurrencyService;
use Modules\Currency\Transformers\CurrencyResource;
use Modules\Currency\Http\Requests\IndexCurrencyRequest;
use Modules\Currency\Http\Requests\StoreCurrencyRequest;
use Modules\Currency\Http\Requests\UpdateCurrencyRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyController extends Controller
{
    public CurrencyService $service;

    /**
     * Create a new repository instance.
     * @param CurrencyService $service
     * @return void
     */
    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCurrencyRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexCurrencyRequest $request): AnonymousResourceCollection
    {
        $currencies = $this->service->all($request->validated());

        return CurrencyResource::collection($currencies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCurrencyRequest $request
     * @return JsonResponse
     */
    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return CurrencyResource
     */
    public function show($slug): CurrencyResource
    {
        $currency = $this->service->find($slug);

        return new CurrencyResource($currency);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateCurrencyRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateCurrencyRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
