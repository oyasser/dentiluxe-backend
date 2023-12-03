<?php

namespace Modules\Currency\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Currency\Repositories\Contracts\CurrencyRepository;

class CurrencyService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(CurrencyRepository $repo)
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
     * @param string $slug
     * @param array $data
     * @return int
     */
    public function update(string $slug, array $data): int
    {
        $price = $this->find($slug);

        if ($price->default) {
            return false;
        }

        return $price->update($data);
    }

    /**
     * @param string $slug
     * @return Model
     */
    public function find(string $slug): Model
    {
        return $this->repo()->findOrFailBySlug($slug);
    }
}
