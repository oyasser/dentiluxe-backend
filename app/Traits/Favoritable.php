<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Favorite\Models\Favorite;

trait  Favoritable
{
    /**
     * Boot the trait.
     */
    protected static function bootFavoritable(): void
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    /**
     * A reply can be favorited.
     *
     * @return MorphMany
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorite the current item.
     *
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    /**
     * Unfavorite the current reply.
     */
    public function unfavorite(): void
    {
        $this->favorites()->where('user_id', auth()->id())->get()->each->delete();
    }

    /**
     * Determine if the current item has been favorited.
     *
     * @return boolean
     */
    public function isFavorited(): bool
    {
        return !!$this->favorites()->where('user_id', auth()->id())->count();
    }

    /**
     * Fetch the favorited status as a property.
     *
     * @return Attribute
     */
    protected function favorited(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->isFavorited(),
        );
    }

}
