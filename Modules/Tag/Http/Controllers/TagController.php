<?php

namespace Modules\Tag\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Tag\Http\Requests\IndexTagRequest;
use Modules\Tag\Http\Requests\StoreTagRequest;
use Modules\Tag\Http\Requests\UpdateTagRequest;
use Modules\Tag\Services\TagService;
use Modules\Tag\Transformers\TagResource;

class TagController extends Controller
{
    public TagService $service;

    /**
     * Create a new repository instance.
     * @param TagService $service
     * @return void
     */
    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexTagRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexTagRequest $request): AnonymousResourceCollection
    {
        $tags = $this->service->all($request->validated());

        return TagResource::collection($tags);
    }

    /*TagService
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequest $request
     * @return JsonResponse
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param  $slug
     * @return TagResource
     */
    public function show($slug): TagResource
    {
        $tag = $this->service->find($slug);

        return new TagResource($tag);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateTagRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateTagRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
