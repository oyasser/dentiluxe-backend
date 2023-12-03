<?php

namespace Modules\Role\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Role\Repositories\Contracts\RoleRepository;

class RoleService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(RoleRepository $repo)
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
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $role = $this->repo()->create($data);

            $role->givePermissionTo($data['permissions']);
        });
    }

    /**
     * @param string $id
     * @return Model
     */
    public function find(string $id): Model
    {
        return $this->repo()->findOrFail($id, ['*'], ['with' => ['permissions']]);
    }

    /**
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id, array $data): mixed
    {
        return DB::transaction(function () use ($id, $data) {
            $updated = $this->repo()->update($id, $data);

            if (isset($data['permissions'])) {
                $role = $this->repo()->find($id);
                $role->permissions()->sync($data['permissions']);
            }

            return $updated;
        });
    }
}
