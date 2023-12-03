<?php

namespace Modules\Tag\Services;

use App\Services\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Tag\Repositories\Contracts\TagRepository;

class TagService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(TagRepository $repo)
    {
        $this->setRepo($repo);
    }

    /**
     * @param array $filters
     * @return Collection
     */
    public function all(array $filters): Collection
    {
        return $this->repo()->retrieve(['*'], ['filters' => $filters]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->repo()->create($data);
        });
    }

    /**
     * @param string $slug
     * @return Model
     */
    public function find(string $slug): Model
    {
        return $this->repo()->findOrFailBySlug($slug);
    }

    /**
     * @param string $slug
     * @param array $data
     * @return mixed
     */
    public function update(string $slug, array $data): mixed
    {
        return DB::transaction(function () use ($slug, $data) {
            return $this->repo()->updateBySlug($slug, $data);
        });
    }
}
