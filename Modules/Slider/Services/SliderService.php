<?php

namespace Modules\Slider\Services;

use App\Services\Service;
use ArrayKeysCaseTransform\ArrayKeys;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Slider\Repositories\Contracts\SliderRepository;

class SliderService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(SliderRepository $repo)
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
            $slider = $this->repo()->create($data);

            $slider->addImage(request()->file('image'), 'slider');

            return $slider;
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
                $slider = $this->find($slug);
                $slider->updateImage(request()->file('image'), 'slider');
            }

            return $updated;
        });
    }
}
