<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Category\Http\Requests\IndexCategoryRequest;
use Modules\Category\Http\Requests\StoreCategoryRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Services\CategoryService;
use Modules\Category\Transformers\CategoryResource;
use Modules\Item\Transformers\ItemResource;

class CategoryController extends Controller
{
    public CategoryService $service;

    /**
     * Create a new repository instance.
     * @param CategoryService $service
     * @return void
     */
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCategoryRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexCategoryRequest $request): AnonymousResourceCollection
    {
        $categories = $this->service->all($request->validated());

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->create($request->validated());

        return $category ? $this->returnSuccess('success', ['id' => $category->id]) : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return CategoryResource
     */
    public function show($slug): CategoryResource
    {
        $category = $this->service->find($slug);

        return new CategoryResource($category);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateCategoryRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    public function listCategoryTree(IndexCategoryRequest $request): AnonymousResourceCollection
    {
        $categories = $this->service->categoryTree($request->validated());

        return CategoryResource::collection($categories);
    }

    /**
     * @param $categorySlug
     * @return AnonymousResourceCollection
     */
    public function items($categorySlug): AnonymousResourceCollection
    {
        $items = $this->service->items($categorySlug);

        return ItemResource::collection($items);
    }
}
