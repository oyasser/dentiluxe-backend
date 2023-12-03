<?php

namespace Modules\Blog\Services;

use App\Services\Service;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use ArrayKeysCaseTransform\ArrayKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Modules\Blog\Repositories\Contracts\BlogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(BlogRepository $repo)
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
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $blog = $this->repo()->create($data);

            $blog->addImage(request()->file('image'), 'blog');

            return $blog;
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
            $updated = $this->repo()->updateBySlug($slug, ArrayKeys::toSnakeCase(Arr::except($data, ['image'])));


            if (request()->file('image')) {
                $blog = $this->find($slug);
                $blog->updateImage(request()->file('image'), 'blog');
            }

            return $updated;
        });
    }
}
