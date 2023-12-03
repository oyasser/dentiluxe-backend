<?php

namespace Modules\Category\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Category\Repositories\Contracts\CategoryRepository;
use Modules\Item\Repositories\Contracts\ItemRepository;

class CategoryService extends Service
{
    private ItemRepository $itemRepository;

    /**
     * Create a new service instance.
     */
    public function __construct(CategoryRepository $repo, ItemRepository $itemRepository)
    {
        $this->setRepo($repo);
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters): Collection|LengthAwarePaginator
    {
        return $this->repo()->retrievePaginate(['*'], ['filters' => $filters, 'with' => ['image']]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $category = $this->repo()->create($data);

            if ($data['parent_id']) {
                $category->parent()->update(['has_sub' => true]);
            }

            $category->addImage(request()->file('image'), 'category');

            return $category;
        });
    }

    /**
     * @param string $slug
     * @param array $data
     * @return mixed
     */
    public function update(string $slug, array $data): mixed
    {
        $category = $this->repo()->findOrFailBySlug($slug);

        return DB::transaction(function () use ($data, $category) {

            $parent = $category->parent;

            if ($parent && $parent->sub()->count() == 1) {
                $parent->update(['has_sub' => false]);
            }

            if ($newParentCategory = $data['parent_id']) {
                $this->repo()->update($newParentCategory, ['has_sub' => true]);
            }

            $category->update(Arr::except($data, ['image']));

            if (request()->file('image')) {
                $category->updateImage(request()->file('image'), 'category');
            }

            return $category;
        });
    }

    /**
     * @param string $slug slug
     */
    public function find(string $slug): Model
    {
        $category = $this->repo()->findOrFailBySlug($slug, ['*'], ['with' => ['allSubCategories.image', 'image']]);

        $category->categories_ids = $category->getPatentsId();

        return $category;
    }

    public function categoryTree(array $filters): Collection
    {
        $options = [
            'filters' => $filters,
            'with' => ['allSubCategories', 'image']
        ];

        return $this->repo()->retrieveBy(['parent_id' => 0], ['*'], $options);
    }

    /**
     * @param $slug
     * @return LengthAwarePaginator
     */
    public function items($slug): LengthAwarePaginator
    {
        return $this->itemRepository->retrievePaginate(['*'], [
            'with' => ['prices'],
            'whereHas' => [
                'relation' => 'categories',
                'callback' => function ($query) use ($slug) {
                    $query->where('slug_' . app()->getLocale(), $slug);
                }
            ]
        ]);
    }
}
