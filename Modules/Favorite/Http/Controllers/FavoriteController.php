<?php

namespace Modules\Favorite\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Favorite\Services\FavoriteService;
use Modules\Favorite\Transformers\FavoriteResource;

class FavoriteController extends Controller
{
    public FavoriteService $service;

    /**
     * Create a new repository instance.
     * @param FavoriteService $service
     * @return void
     */
    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }


    public function index(): AnonymousResourceCollection
    {
        $favourites = $this->service->all([]);

        return FavoriteResource::collection($favourites);
    }

    /**
     * Store a new favorite in the database.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function store($slug): JsonResponse
    {
        $this->service->addToFavorite($slug);

        return $this->returnSuccess();
    }

    /**
     * Delete the favorite.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function destroy($slug): JsonResponse
    {
        $this->service->removeFromFavorite($slug);

        return $this->returnSuccess();
    }
}
