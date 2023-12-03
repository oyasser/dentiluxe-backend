<?php

namespace Modules\Image\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use Paginatable;

    protected $fillable = [
        'image',
        'main',
    ];

    /**
     * Get the parent imageable model (user or post).
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    /**
     * @return Attribute
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/'.$this->image),
        );
    }
}
