<?php

namespace Modules\Cart\Services;

use App\Services\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Repositories\Contracts\CartRepository;
use Modules\Item\Repositories\Contracts\ItemRepository;

class CartService extends Service
{
    private ItemRepository $itemRepository;

    /**
     * Create a new service instance.
     */
    public function __construct(CartRepository $repo, ItemRepository $itemRepository)
    {
        $this->setRepo($repo);

        $this->itemRepository = $itemRepository;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addToCart(array $data): mixed
    {
        return DB::transaction(function () use ($data) {

            $cart = $this->firstOrCreate($data);

            $this->createOrUpdateItem($cart, $data);

            $cart->load('items');

            return $cart;
        });
    }

    /**
     * @param array $data
     * @return Model|null
     */
    protected function firstOrCreate(array $data): Model|null
    {
        return $this->find() ?? $this->repo()->create($data);
    }

    /**
     * @return Model|null
     */
    public function find(): Model|null
    {
        $userId = auth()->id();
        $sessionId = request()->header('session');

        $attributes = auth()->user() ? ['user_id' => $userId] : ['session_id' => $sessionId];

        return $this->repo()->findBy($attributes);
    }

    /**
     * @param $cart
     * @param $data
     * @return void
     */
    protected function createOrUpdateItem($cart, $data): void
    {
        $itemId = $data['item_id'];
        $qty = $data['qty'];

        $cart->items->contains('id', $itemId) ?
            $cart->items()->updateExistingPivot($itemId, ['qty' => $qty]) :
            $cart->items()->attach($itemId, ['qty' => $qty, 'price' => $this->itemRepository->find($itemId)->sales_price]);
    }

    /**
     * @param $item
     * @return bool
     */
    public function removeFromCart($item): bool
    {
        $cart = $this->find();
        if (!$cart) {
            return false;
        }
        return DB::transaction(function () use ($cart, $item) {

            $cart->items()->detach([$item]);

            if (!$cart->items->count()) {
                $cart->delete();
            }
            return true;
        });
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        $cart = $this->find();
        if (!$cart) {
            return false;
        }

        return DB::transaction(function () use ($cart) {

            $cart->items()->detach();
            $cart->delete();

            return true;
        });
    }

    public function getContent(): ?Model
    {
        $cart = $this->find();
        $cart?->load('items');

        return $cart;
    }
}
