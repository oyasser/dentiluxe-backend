<?php

namespace Modules\ClientCategory\Observers;

use Modules\ClientCategory\Models\ClientCategory;

class ClientCategoryObserver
{
    /**
     * Handle the client category "created" event.
     *
     * @param ClientCategory $category
     * @return void
     */
    public function creating(ClientCategory $category)
    {
        if (request()->has('is_default') && request('is_default')) {
            ClientCategory::query()->update(['is_default' => false]);
        }
    }

    /**
     * Handle the client "updated" event.
     *
     * @param ClientCategory $category
     * @return void
     */
    public function updating(ClientCategory $category)
    {
        if (request()->has('is_default') && request('is_default')) {
            ClientCategory::query()->update(['is_default' => false]);
            ClientCategory::query()->where('id', $category->id)->update(['is_default' => true]);
        }
    }
}
