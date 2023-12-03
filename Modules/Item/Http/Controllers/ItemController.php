<?php

namespace Modules\Item\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Item\Http\Requests\IndexItemRequest;
use Modules\Item\Http\Requests\StoreItemRequest;
use Modules\Item\Http\Requests\UpdateItemRequest;
use Modules\Item\Services\ItemService;
use Modules\Item\Transformers\ItemResource;

class ItemController extends Controller
{
    public ItemService $service;

    /**
     * Create a new repository instance.
     * @param ItemService $service
     * @return void
     */
    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexItemRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexItemRequest $request): AnonymousResourceCollection
    {
        $items = $this->service->all($request->validated());

        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return ItemResource
     */
    public function show($slug): ItemResource
    {
        $item = $this->service->find($slug);

        return new ItemResource($item);
    }

    /**
     * Update the resource value.
     * @param UpdateItemRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateItemRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * @param $slug
     * @return AnonymousResourceCollection
     */
    public function related($slug): AnonymousResourceCollection
    {
        $items = $this->service->getRelatedItems($slug);

        return ItemResource::collection($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexItemRequest $request
     * @return JsonResponse
     */
    public function featured(IndexItemRequest $request)
    {
        $items = $this->service->featured($request->validated());

        return $this->response([
            'data' => ['trending' => ItemResource::collection($items->first()), 'bestSeller' => ItemResource::collection($items->last())]
        ], 200);
    }
}
