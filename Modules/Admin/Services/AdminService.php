<?php

namespace Modules\Admin\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\Contracts\AdminRepository;

class AdminService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(AdminRepository $repo)
    {
        $this->setRepo($repo);
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters): Collection|LengthAwarePaginator
    {
        $options = [
            'filters' => $filters,
            'with' => ['categories', 'prices'],
        ];
        return $this->repo()->retrievePaginate(['*'], $options);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $admin = $this->repo()->create($data);

            $admin->assignRole($data['roles']);

            //$token = app(PasswordBroker::class)->createToken($admin);

            //$admin->notify(new WelcomeNotification($token));

            return $admin;
        });
    }

    /**
     * @param int|string $id
     * @return Model
     */
    public function find(int|string $id): Model
    {
        return $this->repo()->findOrFail($id, ['*'], ['with' => ['roles']]);
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
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed
    {
        return DB::transaction(function () use ($id, $data) {
            $updated = $this->repo()->update($id, $data);

            if (isset($data['roles'])) {
                $admin = $this->repo()->findOrFail($id);

                $admin->syncRoles($data['roles']);
            }

            return $updated;
        });
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
}
