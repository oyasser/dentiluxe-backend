<?php

namespace Modules\SalesOrder\Services;

use Exception;
use App\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Modules\PromoCode\Services\PromoCodeService;
use Modules\Cart\Repositories\Contracts\CartRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\SalesOrder\Repositories\Contracts\SalesOrderRepository;

class SalesOrderService extends Service
{
    private CartRepository $cartRepository;
    private PromoCodeService $promoCodeService;
    private Model $salesOrder;
    private ?Collection $items;
    private float $subTotal = 0;
    private float $discount = 0;

    /**
     * Create a new service instance.
     */
    public function __construct(
        SalesOrderRepository $repo,
        CartRepository       $cartRepository,
        PromoCodeService     $promoCodeService,
    ) {
        $this->setRepo($repo);
        $this->cartRepository   = $cartRepository;
        $this->promoCodeService = $promoCodeService;
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters): Collection|LengthAwarePaginator
    {
        $options = [
            'filters' => $filters,
            'with'    => ['items'],
        ];

        return $this->repo()->retrievePaginate(['*'], $options);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        try {
            return DB::transaction(function () use ($data) {
                $cart = $this->getCartWithItems();

                $this->salesOrder = $this->repo()->create(['user_id' => auth()->id(), 'details' => $data['details']]);

                $this->storeOrderDetails();

                $this->calculateOrderPrice();

                $this->deleteCompletedCart($cart);

                if (isset($data['code'])) {
                    $this->calculateDiscount($data['code']);
                    $this->applyPromoCode($data['code']);
                }

                $this->repo()->update($this->salesOrder->id, [
                    'sub_total' => $this->subTotal,
                    'discount'  => $this->discount,
                    'total'     => $this->subTotal - $this->discount,
                ]);

                return true;
            });
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return Model
     */
    public function getCartWithItems(): Model
    {
        $userId    = auth()->id();
        $sessionId = request()->header('session');

        $attributes = auth()->user() ? ['user_id' => $userId] : ['session_id' => $sessionId];
        $cart       = $this->cartRepository->findBy($attributes, ['*'], ['with' => ['items']]);

        $this->items = $cart->items;

        return $cart;
    }

    protected function storeOrderDetails()
    {
        foreach ($this->items as $item) {
            $this->salesOrder->items()->attach($item->id, [
                'item_id' => $item->id,
                'qty'     => $item->pivot->qty,
                'price'   => $item->salesPrice,
            ]);
        }
    }

    protected function calculateOrderPrice()
    {
        foreach ($this->items as $item) {
            $this->subTotal += $item->pivot->qty * $item->salesPrice;
        }
    }

    /**
     * @param $cart
     * @return void
     */
    public function deleteCompletedCart($cart): void
    {
        $this->cartRepository->destroy($cart->id);
    }

    /**
     * @param $code
     * @return void
     */
    public function calculateDiscount($code): void
    {
        $this->discount = $this->promoCodeService->calculateDiscount($code, $this->items);
    }

    /**
     * @param string $code
     */
    public function applyPromoCode(string $code)
    {
        $this->promoCodeService->apply($code, $this->salesOrder);
    }

    /**
     * @param string $orderNumber
     * @param array $data
     * @return int
     */
    public function update(string $orderNumber, array $data): int
    {
        return $this->repo()->updateBy(['order_number' => $orderNumber], $data);
    }

    /**
     * @param string $orderNumber
     * @return Model
     */
    public function find(string $orderNumber): Model
    {
        return $this->repo()->findOrFailBy(['order_number' => $orderNumber], ['*'], ['with' => ['items']]);
    }
}
