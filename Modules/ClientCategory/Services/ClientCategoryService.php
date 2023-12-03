<?php

namespace Modules\ClientCategory\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\ClientCategory\Repositories\Contracts\ClientCategoryRepository;

class ClientCategoryService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(ClientCategoryRepository $repo)
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
        return $this->repo()->create($data);
    }

    /**
     * @param string $slug slug
     */
    public function find(string $slug): Model
    {
        return $this->repo()->findOrFailBySlug($slug);
    }

    /**
     * @param string $slug
     * @param array $data
     * @return int
     */
    public function update(string $slug, array $data): int
    {
        return $this->repo()->update($slug, $data);
    }
}
