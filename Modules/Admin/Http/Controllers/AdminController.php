<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Admin\Services\AdminService;
use Modules\Admin\Transformers\AdminResource;
use Modules\Admin\Http\Requests\ProfileRequest;
use Modules\Admin\Http\Requests\IndexAdminRequest;
use Modules\Admin\Http\Requests\StoreAdminRequest;
use Modules\Admin\Http\Requests\UpdateAdminRequest;
use Modules\Admin\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminController extends Controller
{
    public AdminService $service;

    /**
     * Create a new repository instance.
     * @param AdminService $service
     * @return void
     */
    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAdminRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexAdminRequest $request): AnonymousResourceCollection
    {
        $admins = $this->service->all($request->validated());

        return AdminResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdminRequest $request
     * @return JsonResponse
     */
    public function store(StoreAdminRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return AdminResource
     */
    public function show($id): AdminResource
    {
        $admin = $this->service->find($id);

        return new AdminResource($admin);
    }

    /**
     * Update the resource status value.
     *
     * @param UpdateAdminRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateAdminRequest $request, $id): JsonResponse
    {
        return $this->service->update($id, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * @return AdminResource
     */
    public function profile(): AdminResource
    {
        $admin = auth()->user()->with('roles')->first();

        return new AdminResource($admin);
    }

    /**
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(ProfileRequest $request): JsonResponse
    {
        return $this->service->updateProfile(auth()->id(), $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(UpdatePasswordRequest $request): JsonResponse
    {
        return $this->service->changePassword($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }
}
