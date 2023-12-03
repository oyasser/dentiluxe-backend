<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Blog\Http\Requests\IndexBlogRequest;
use Modules\Blog\Http\Requests\StoreBlogRequest;
use Modules\Blog\Http\Requests\UpdateBlogRequest;
use Modules\Blog\Services\BlogService;
use Modules\Blog\Transformers\BlogResource;

class BlogController extends Controller
{
    public BlogService $service;

    /**
     * Create a new repository instance.
     * @param BlogService $service
     * @return void
     */
    public function __construct(BlogService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexBlogRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexBlogRequest $request): AnonymousResourceCollection
    {
        $blogs = $this->service->all($request->validated());

        return BlogResource::collection($blogs);
    }

    /*BlogService
     * Store a newly created resource in storage.
     *
     * @param StoreBlogRequest $request
     * @return JsonResponse
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return BlogResource
     */
    public function show($slug): BlogResource
    {
        $blog = $this->service->find($slug);

        return new BlogResource($blog);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateBlogRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateBlogRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
