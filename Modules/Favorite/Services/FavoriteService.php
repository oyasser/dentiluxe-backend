<?php

namespace Modules\Favorite\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Favorite\Repositories\Contracts\FavoriteRepository;
use Modules\Item\Repositories\Contracts\ItemRepository;

class FavoriteService extends Service
{
    private ItemRepository $itemRepository;

    /**
     * Create a new service instance.
     */
    public function __construct(FavoriteRepository $repo, ItemRepository $itemRepository)
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
        $options = [
            'filters' => $filters,
            'with' => ['favorited']
        ];
        $attributes = ['user_id' => auth()->id()];
        return $this->repo()->retrieveByPaginate($attributes, ['*'], $options);
    }

    /**
     * @param string $data
     * @return void
     */
    public function addToFavorite(string $data): void
    {
        $item = $this->itemRepository->findBySlug($data);

        $item->favorite();
    }

    /**
     * Delete the favorite.
     *
     * @param $data
     * @return void
     */
    public function removeFromFavorite($data): void
    {
        $item = $this->itemRepository->findBySlug($data);

        $item->unfavorite();
    }
}
