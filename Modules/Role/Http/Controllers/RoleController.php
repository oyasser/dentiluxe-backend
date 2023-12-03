<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Role\Services\RoleService;
use Modules\Role\Transformers\RoleResource;
use Modules\Role\Http\Requests\StoreRoleRequest;
use Modules\Role\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    public RoleService $service;

    /**
     * Create a new repository instance.
     * @param RoleService $service
     * @return void
     */
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $roles = $this->service->all($request->all());

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        return $this->service->create($request->validated()) ? $this->returnSuccess() : $this->returnBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RoleResource
     */
    public function show(int $id): RoleResource
    {
        $role = $this->service->find($id);

        return new RoleResource($role);
    }

    /**
     * Update the resource values.
     *
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        return $this->service->update($id, $request->validated()) ? $this->returnSuccess() : $this->returnBadRequest('Can not update default price');
    }
}
