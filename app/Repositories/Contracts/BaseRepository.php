<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BaseRepository
{
    /**
     * Retrieve all data from the database.
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieve(array $columns = ['*'], array $options = []): Collection;

    /**
     * Retrieve data paginated from the database.
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrievePaginate(array $columns = ['*'], array $options = []): LengthAwarePaginator;

    /**
     * Retrieve all conditioning data from database.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveBy(array $conditions, array $columns = ['*'], array $options = []);

    /**
     * Retrieve conditioning data paginated from database.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveByPaginate(array $conditions, array $columns = ['*'], array $options = []): LengthAwarePaginator;

    /**
     * Retrieve all optional conditioning data from database.
     * @param array $conditions
     * @param array $orConditions
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveByOptional(array $conditions, array $orConditions, array $columns = ['*'], array $options = []): Collection;

    /**
     * Retrieve optional conditioning data paginated from database.
     * @param array $conditions
     * @param array $orConditions
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveByOptionalPaginate(array $conditions, array $orConditions, array $columns = ['*'], array $options = []): LengthAwarePaginator;

    /**
     * Retrieve all joined data ASC from the database
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveJoined(array $joins, array $columns = ['*'], array $options = []): Collection;

    /**
     * Retrieve joined data paginated from the database
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveJoinedPaginate(array $joins, array $columns = ['*'], array $options = []): LengthAwarePaginator;

    /**
     * Retrieve all conditioning joined data from the database
     * @param array $conditions
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveJoinedBy(array $conditions, array $joins, array $columns = ['*'], array $options = []): Collection;

    /**
     * Retrieve conditioning joined data paginated from the database
     * @param array $conditions
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveJoinedByPaginate(array $conditions, array $joins, array $columns = ['*'], array $options = []): LengthAwarePaginator;

    /**
     * Retrieve all data where id in array from database.
     * @param array $ids
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveByIds(array $ids, array $columns = ['*'], array $options = []): Collection;

    /**
     * Find the given id.
     * @param int|string $id
     * @param array $columns
     * @param array $options
     * @return Model|null
     */
    public function find(int|string $id, array $columns = ['*'], array $options = []);

    /**
     * Find by condition.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return Model|null
     */
    public function findBy(array $conditions, array $columns = ['*'], array $options = []): ?Model;

    /**
     * Find by slug.
     * @param string $slug
     * @param array $columns
     * @param array $options
     * @return Model|null
     */
    public function findBySlug(string $slug, array $columns = ['*'], array $options = []): Model|null;

    /**
     * Find the given id or fail.
     * @param int|string $id
     * @param array $columns
     * @param bool $trashed
     * @return Model
     */
    public function findOrFail(int|string $id, array $columns = ['*'], array $options = []): Model;

    /**
     * Find or fail by condition.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return Model
     */
    public function findOrFailBy(array $conditions, array $columns = ['*'], array $options = []): Model;

    /**
     * Find or fail by slug.
     * @param string $slug
     * @param array $columns
     * @param array $options
     * @return Model
     */
    public function findOrFailBySlug(string $slug, array $columns = ['*'], array $options = []): Model;

    /**
     * Create new record.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * createMany new record.
     * @param array $data
     * @return Model
     */
    public function createMany(array $data): bool;

    /**
     * Update the given record id.
     * @param int|string $id
     * @param array $data
     * @return int
     *
     */
    public function update(int|string $id, array $data): int;

    /**
     * Update the given records ids.
     * @param array $ids
     * @param array $data
     * @return int
     */
    public function updateMany(array $ids, array $data): int;

    /**
     * Update data by conditions.
     * @param array $conditions
     * @param array $data
     * @return int
     */
    public function updateBy(array $conditions, array $data): int;

    /**
     * Update the given record id.
     * @param string $slug
     * @param array $data
     * @return int
     */
    public function updateBySlug(string $slug, array $data): int;

    /**
     * Destroy the given record id.
     * @param int|string $id
     * @return boolean|null
     *
     * @throws ModelNotFoundException
     */
    public function destroy($id): ?bool;

    /**
     * Destroy the given records list ids.
     * @param array $ids
     * @return boolean
     */
    public function destroyMany(array $ids): bool;

    /**
     * Restore the given record id.
     * @param int|string $id
     * @return boolean|null
     *
     * @throws ModelNotFoundException
     */
    public function restore($id): ?bool;

    /**
     * Restore the given records list ids.
     * @param array $ids
     * @return boolean
     */
    public function restoreMany(array $ids): bool;

    /**
     * Force Destroy the given record id.
     * @param int|string $id
     * @return boolean|null
     *
     * @throws ModelNotFoundException
     */
    public function forceDestroy($id): ?bool;

    /**
     * Force Destroy the given records list ids.
     * @param array $ids
     * @return boolean
     */
    public function forceDestroyMany(array $ids): bool;
}
