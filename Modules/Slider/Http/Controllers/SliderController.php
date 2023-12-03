<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Slider\Models\Slider;
use App\Http\Controllers\Controller;
use Modules\Slider\Services\SliderService;
use Modules\Slider\Transformers\SliderResource;
use Modules\Slider\Http\Requests\IndexSliderRequest;
use Modules\Slider\Http\Requests\StoreSliderRequest;
use Modules\Slider\Http\Requests\UpdateSliderRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SliderController extends Controller
{
    public SliderService $service;

    /**
     * Create a new repository instance.
     * @param SliderService $service
     * @return void
     */
    public function __construct(SliderService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexSliderRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexSliderRequest $request): AnonymousResourceCollection
    {
        $sliders = $this->service->all($request->validated());

        return SliderResource::collection($sliders);
    }

    /*SliderService
     * Store a newly created resource in storage.
     *
     * @param StoreSliderRequest $request
     * @return JsonResponse
     */
    public function store(StoreSliderRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @return SliderResource
     */
    public function show(Slider $slider): SliderResource
    {
        return new SliderResource($slider);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateSliderRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateSliderRequest $request, $slug): JsonResponse
    {
        return $this->service->update($slug, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
