<?php

namespace Modules\User\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Repositories\Contracts\UserRepository;

class UserService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(UserRepository $repo)
    {
        $this->setRepo($repo);
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters): Collection|LengthAwarePaginator
    {
        return $this->repo()->retrievePaginate(['*'], ['filters' => $filters]);
    }

    /**
     * @param int|string $id
     * @return Model
     */
    public function find(int|string $id): Model
    {
        return $this->repo()->findOrFail($id);
    }

    /**
     * @param int|string $id
     * @param array $data
     * @return int
     */
    public function updateProfile(int|string $id, array $data): int
    {
        return $this->repo()->update($id, $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function changePassword($data): mixed
    {
        return auth()->user()->fill([
            'password' => $data['password'],
        ])->save();
    }

    /**
     * @param $orderNumber
     * @return mixed
     */
    public function orderDetails($orderNumber): mixed
    {
        return auth()->user()
            ->orders()
            ->with(['items'])
            ->where('order_number', $orderNumber)
            ->first();
    }

    /**
     * @return mixed
     */
    public function orders(): mixed
    {
        $user = auth()->user();

        $user->load('orders.items');

        return $user->orders;
    }
}
