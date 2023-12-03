<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait Localization
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug_' . app()->getLocale();
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug_en' => [
                'source' => 'name_en',
            ],
            'slug_ar' => [
                'source' => 'name_en',
            ],
        ];
    }

    /**
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->{'name_' . app()->getLocale()};
            },
        );
    }

    /**
     * @return Attribute
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->{'slug_' . app()->getLocale()};
            },
        );
    }

    /**
     * @return Attribute
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->{'description_' . app()->getLocale()};
            },
        );
    }
}
