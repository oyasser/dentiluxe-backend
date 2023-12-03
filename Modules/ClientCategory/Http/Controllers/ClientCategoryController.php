<?php

namespace Modules\ClientCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\ClientCategory\Http\Requests\IndexClientCategoryRequest;
use Modules\ClientCategory\Http\Requests\StoreClientCategoryRequest;
use Modules\ClientCategory\Http\Requests\UpdateClientCategoryRequest;
use Modules\ClientCategory\Services\ClientCategoryService;
use Modules\ClientCategory\Transformers\ClientCategoryResource;

class ClientCategoryController extends Controller
{
    private ClientCategoryService $service;

    /**
     * Create a new repository instance.
     * @param ClientCategoryService $service
     * @return void
     */
    public function __construct(ClientCategoryService $service)
    {
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     * @param IndexClientCategoryRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexClientCategoryRequest $request): AnonymousResourceCollection
    {
        $clientCategories = $this->service->all($request->validated());

        return ClientCategoryResource::collection($clientCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreClientCategoryRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return ClientCategoryResource
     */
    public function show($slug): ClientCategoryResource
    {
        $clientCategory = $this->service->find($slug);

        return new ClientCategoryResource($clientCategory);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateClientCategoryRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateClientCategoryRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
