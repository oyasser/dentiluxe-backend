<?php

namespace Modules\PromoCode\Services;

use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Cart\Repositories\Contracts\CartRepository;
use Modules\PromoCode\Contracts\PromoCodeFactory;
use Modules\PromoCode\Exceptions\PromocodeAlreadyUsedByUserException;
use Modules\PromoCode\Exceptions\PromocodeBoundToOtherUserException;
use Modules\PromoCode\Exceptions\PromocodeDoesNotExistException;
use Modules\PromoCode\Exceptions\PromocodeExpiredException;
use Modules\PromoCode\Exceptions\PromocodeNoUsagesLeftException;
use Modules\PromoCode\Models\PromocodeRedemption;
use Modules\PromoCode\Repositories\Contracts\PromoCodeRepository;

class PromoCodeService extends Service
{
    private ?Model $promoCode;

    /**
     * Create a new service instance.
     */
    public function __construct(PromoCodeRepository $repo, CartRepository $cartRepository)
    {
        $this->setRepo($repo);
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters): Collection|LengthAwarePaginator
    {
        return $this->repo()->retrievePaginate(['*']);
    }

    /**
     * @param string $code
     * @return Model
     */
    public function find(string $code): Model
    {
        return $this->repo()->findOrFailBy(['code' => $code], ['*'], ['with' => ['items']]);
    }

    /**
     * Update the resource status value.
     *
     * @param $code
     * @return bool
     */
    public function expirePromoCode($code): bool
    {
        $promoCode = $this->repo()->findBy(['code' => $code]);

        if (!$promoCode) {
            throw new PromocodeDoesNotExistException($code);
        }
        return $this->repo()->update($promoCode->id, ['expired_at' => now()]);
    }

    /**
     * @param string $code
     * @param array $data
     * @return bool
     */
    public function update(string $code, array $data): bool
    {
        $payload = $data;
        if (isset($data['items'])) {
            $payload = Arr::except($data, 'items');
        }

        $this->repo()->updateBy(['code' => $code], $payload);

        if (isset($data['items'])) {
            $promoCode = $this->repo()->findBy(['code' => $code]);
            $promoCode->items()->attach($data['items']);
        }
        return true;
    }

    public function calculateDiscount($code, $items = null): mixed
    {
            $promoCode = $this->repo()->findBy(['code' => $code], ['*'], ['with' => ['items']]);

            $this->promoCode = $promoCode;

            $this->validate();

            $userId = auth()->id();
            $sessionId = request()->header('session');

            $attributes = auth()->user() ? ['user_id' => $userId] : ['session_id' => $sessionId];

            $cartItems = $items ?? $this->cartRepository->findOrFailBy($attributes, ['*'], ['with' => ['items']])?->items;

            return $this->getDiscount($cartItems, $promoCode);
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $user = auth()->user();

        if (!$this->promoCode) {
            throw new PromocodeDoesNotExistException();
        }

        if ($this->promoCode->isExpired()) {
            throw new PromocodeExpiredException($this->promoCode?->code);
        }

        if (!$this->promoCode->hasUsagesLeft()) {
            throw new PromocodeNoUsagesLeftException($this->promoCode?->code);
        }

        if ($user) {
            if (!$this->promoCode->allowedForUser($user)) {
                throw new PromocodeBoundToOtherUserException($user, $this->promoCode?->code);
            }

//            if (!$this->promoCode?->multi_use && $this->promoCode->appliedByUser($user)) {
//                throw new PromocodeAlreadyUsedByUserException($user, $this->promoCode?->code);
//            }
        }
        return true;
    }

    /**
     * @param $cartItems
     * @param Model|null $promoCode
     * @return mixed
     */
    protected function getDiscount($cartItems, ?Model $promoCode): mixed
    {
        return PromoCodeFactory::make($cartItems, $promoCode)->calculateDiscount($promoCode, $cartItems);
    }

    public function apply($code, $salesOrder)
    {
        $promoCode = $this->repo()->findBy(['code' => $code]);
        $this->promoCode = $promoCode;

        $this->validate();

        PromocodeRedemption::create([
            'user_id' => auth()->id(),
            'promocode_id' => $promoCode->id,
            'sales_order_id' => $salesOrder->id
        ]);

        if ($promoCode->usages != '-1') {
            $promoCode->decrement('usages');
        }
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $promoCode = $this->repo()->create($data);

        if (isset($data['items'])) {
            $promoCode->items()->attach($data['items']);
        }
        return $promoCode;
    }
}
