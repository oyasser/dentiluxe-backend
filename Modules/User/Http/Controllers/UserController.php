<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\SalesOrder\Transformers\SalesOrderResource;
use Modules\User\Http\Requests\IndexUserRequest;
use Modules\User\Http\Requests\ProfileRequest;
use Modules\User\Http\Requests\UpdatePasswordRequest;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserResource;

class UserController extends Controller
{
    public UserService $service;

    /**
     * Create a new repository instance.
     * @param UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexUserRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexUserRequest $request): AnonymousResourceCollection
    {
        $users = $this->service->all($request->validated());

        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return UserResource
     */
    public function show($id): UserResource
    {
        $user = $this->service->find($id);

        return new UserResource($user);
    }

    public function profile(): UserResource
    {
        return new UserResource(auth()->user());
    }

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

    /**
     * @param $number
     * @return SalesOrderResource
     */
    public function order($number): SalesOrderResource
    {
        $userOrder = $this->service->orderDetails($number);

        return new SalesOrderResource($userOrder);
    }

    public function orders(): AnonymousResourceCollection
    {
        $userOrders = $this->service->orders();

        return SalesOrderResource::collection($userOrders);
    }
}
