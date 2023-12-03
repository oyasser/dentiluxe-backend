<?php

namespace Modules\Favorite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Fetch the model that was favorited.
     *
     * @return MorphTo
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
