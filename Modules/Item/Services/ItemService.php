<?php

namespace Modules\Item\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Item\Repositories\Contracts\ItemRepository;

class ItemService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(ItemRepository $repo)
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
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function featured(array $filters): Collection|LengthAwarePaginator
    {
        $filters['best_seller'] = 1;
        $filters['trending'] = 1;

        $options = [
            'filters' => $filters,
            'with' => ['categories', 'prices'],
        ];

        return $this->repo()->retrieve(['*'], $options)->groupBy('trending');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $item = $this->repo()->create($data);

            $item->categories()->attach($data['categories']);

            $item->prices()->attach($data['prices']);

            $item->tags()->attach($data['tags']);

            $item->addImages($data['images'], 'items');

            if ($item->is_bundle) {
                $item->bundleItems()->attach($data['items']);
            }

            return $item;
        });
    }

    /**
     * @param string $slug slug
     */
    public function find(string $slug): Model
    {
        $item = $this->repo()->findOrFailBySlug($slug, ['*'], ['with' => ['categories', 'prices']]);

        if ($item->is_bundle) {
            $item->load('bundleItems');
        }

        return $item;
    }

    /**
     * @param string $slug
     * @param array $data
     * @return int
     */
    public function update(string $slug, array $data): int
    {
        $item = $this->repo()->findOrFailBySlug($slug);

        return DB::transaction(function () use ($data, $item) {
            $updated = $item->update($data);

            if (isset($data['categories'])) {
                $item->categories()->sync($data['categories']);
            }

            if (isset($data['prices'])) {
                $item->prices()->sync($data['prices']);
            }

            if (isset($data['tags'])) {
                $item->tags()->sync($data['tags']);
            }

            if ($images = request()->file('images')) {
                $item->addImages($images, 'items');
            }

            return $updated;
        });
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getRelatedItems($slug): mixed
    {
        $item = $this->repo()->findOrFailBySlug($slug);

        $categoryId = $item->categories->last()->id;

        return $this->repo()->retrievePaginate(['*'], [
            'with' => ['prices'],
            'whereHas' => [
                'relation' => 'categories',
                'callback' => function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                }
            ]
        ]);
    }
}
