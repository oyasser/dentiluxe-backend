<?php

namespace App\Traits;

trait  Paginatable
{
    protected int $perPageMax = 100;

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage(): int
    {
        $perPage = request('per_page', $this->perPage);

        if ($perPage == 0) {
            $perPage = $this->count();
        }
        return max(1, min($this->perPageMax, (int) $perPage));
    }
}
