<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Repository implements BaseRepository
{
    /**
     * Repository model.
     * @var Model
     */
    protected Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve data from the database.
     * @param array $columns
     * @param array $options ['orderBy', 'direction', 'filters']
     * @return Collection
     */
    public function retrieve(array $columns = ['*'], array $options = []): Collection
    {
        return $this->retrieveQuery($columns, $options)->get();
    }

    /**
     * Build Retrieve query.
     * @param array $columns
     * @param array $options
     * @return Builder
     */
    protected function retrieveQuery(array $columns = ['*'], array $options = []): Builder
    {
        $builder = $this->select($columns);

        $this->sortBy($options, $builder);

        $this->join($options, $builder);

        $this->with($options, $builder);

        $this->has($options, $builder);

        $this->whereHas($options, $builder);

        $this->distinct($options, $builder);

        $this->filter($options, $builder);

        $this->groupBy($options, $builder);

        $this->limit($options, $builder);

        return $builder;
    }

    /**
     * Set select columns.
     * @param array $columns
     * @return Builder
     */
    protected function select(array $columns = ['*']): Builder
    {
        return $this->builder()->selectRaw(implode(',', $columns));
    }

    /**
     * return query builder.
     * @return Builder
     */
    protected function builder(): Builder
    {
        return $this->model->query();
    }

    /**
     * @param $options
     * @param Builder $builder
     * @return void
     */
    protected function sortBy($options, Builder $builder): void
    {
        if (key_exists('filters', $options) && is_array($options['filters']) && count($options['filters'])) {
            $sort           = $options['filters']['sort'] ?? 'id';
            $direction      = $options['filters']['direction'] ?? 'desc';
            $sortArray      = is_array($sort) ? $sort : [$sort];
            $directionArray = is_array($direction) ? $direction : [$direction];

            foreach ($sortArray as $key => $sort) {
                $builder->orderBy($this->prefixTable($sort), $directionArray[$key] ?? 'desc');
            }
        }
    }

    /**
     * prefix the given column with model table name.
     * @param string $column
     * @return string
     */
    protected function prefixTable(string $column): string
    {
        if (Str::contains($column, '.')) {
            return $column;
        } elseif (Str::startsWith($column, '@')) {
            return Str::afterLast($column, '@');
        }


        return $this->model->getTable() . '.' . $column;
    }

    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function join(array $options, Builder $builder): void
    {
        if (key_exists('joins', $options) && is_array($options['joins']) && count($options['joins'])) {
            foreach ($options['joins'] as $join) {
                $builder->{$join}();
            }
        }
    }

    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function with(array $options, Builder $builder): void
    {
        if (key_exists('with', $options) && is_array($options['with']) && count($options['with'])) {
            $builder->with($options['with']);
        }
    }

    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function has(array $options, Builder $builder): void
    {
        if (key_exists('has', $options) && !empty($options['has'])) {
            $builder->has($options['has']);
        }
    }

    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function whereHas(array $options, Builder $builder): void
    {
        if (key_exists('whereHas', $options) && !empty($options['whereHas'])) {
            $builder->whereHas($options['whereHas']['relation'], $options['whereHas']['callback'] ?? null);
        }
    }


    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function distinct(array $options, Builder $builder): void
    {
        if (in_array('distinct', $options) && $options['distinct']) {
            $builder->distinct();
        }
    }

    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function filter(array $options, Builder $builder): void
    {
        if (key_exists('filters', $options) && Arr::except($options['filters'], ['sort', 'direction'])) {
            $builder->filter($options['filters'] ?? []);
        }
    }

    /**
     * @param array $options
     * @param Builder $builder
     * @return void
     */
    protected function groupBy(array $options, Builder $builder): void
    {
        if (key_exists('groupBy', $options)) {
            $builder->groupBy($options['groupBy']);
        }
    }

    protected function limit(array $options, Builder $builder): void
    {
        if (key_exists('limit', $options)) {
            $builder->limit($options['limit']);
        }
    }

    /**
     * Retrieve data paginated from the database.
     * @param array $columns
     * @param array $options ['orderBy', 'direction', 'filters']
     * @return LengthAwarePaginator
     */
    public function retrievePaginate(array $columns = ['*'], array $options = []): LengthAwarePaginator
    {
        return $this->retrieveQuery($columns, $options)->paginate();
    }

    /**
     * Retrieve all conditioning data from database.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveBy(array $conditions, array $columns = ['*'], array $options = []): Collection
    {
        return $this->retrieveQuery($columns, $options)->where($conditions)->get();
    }

    /**
     * Retrieve conditioning data paginated from database.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveByPaginate(array $conditions, array $columns = ['*'], array $options = []): LengthAwarePaginator
    {
        return $this->retrieveQuery($columns, $options)->where($conditions)->paginate();
    }

    /**
     * Retrieve all optional conditioning data from database.
     * @param array $conditions
     * @param array $orConditions
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveByOptional(array $conditions, array $orConditions, array $columns = ['*'], array $options = []): Collection
    {
        return $this->retrieveQuery($columns, $options)->where($conditions)->orWhere($orConditions)->get();
    }

    /**
     * Retrieve optional conditioning data paginated from database.
     * @param array $conditions
     * @param array $orConditions
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveByOptionalPaginate(array $conditions, array $orConditions, array $columns = ['*'], array $options = []): LengthAwarePaginator
    {
        return $this->retrieveQuery($columns, $options)->where($conditions)->orWhere($orConditions)->paginate();
    }

    /**
     * Retrieve all joined data ASC from the database
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveJoined(array $joins, array $columns = ['*'], array $options = []): Collection
    {
        return $this->retrieveQuery($columns, Arr::add($options, 'joins', $joins))->get();
    }

    /**
     * Retrieve joined data paginated from the database
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveJoinedPaginate(array $joins, array $columns = ['*'], array $options = []): LengthAwarePaginator
    {
        return $this->retrieveQuery($columns, Arr::add($options, 'joins', $joins))->paginate();
    }

    /**
     * Retrieve all conditioning joined data from the database
     * @param array $conditions
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveJoinedBy(array $conditions, array $joins, array $columns = ['*'], array $options = []): Collection
    {
        return $this->retrieveQuery($columns, Arr::add($options, 'joins', $joins))->where($conditions)->get();
    }

    /**
     * Retrieve all conditioning joined data from the database
     * @param array $conditions
     * @param array $joins
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function retrieveJoinedByPaginate(array $conditions, array $joins, array $columns = ['*'], array $options = []): LengthAwarePaginator
    {
        return $this->retrieveQuery($columns, Arr::add($options, 'joins', $joins))->where($conditions)->paginate();
    }

    /**
     * Checker method to search for the given method on model before throws an exception.
     * @param string $method
     * @param mixed $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call(string $method, mixed $arguments)
    {
        if (method_exists($this->model, $method)) {
            return $this->model->{$method}(...$arguments);
        }

        throw new Exception(sprintf("Can't find method (%s) on %s or its model ", $method, static::class));
    }

    /**
     * Try to get the given dependency
     * @param string $dependency
     * @return mixed
     * @throws Exception
     */
    public function __get(string $dependency)
    {
        if (!method_exists($this, $dependency)) {
            throw new Exception(sprintf(
                "Call undefined (%s) property. [Tip] try to use setModel() method in your constructor.",
                $dependency
            ));
        }

        return $this->{$dependency}();
    }

    /**
     * Find the given id or fail.
     * @param int|string $id
     * @param array $columns
     * @param bool $trashed
     * @return Model
     */
    public function findOrFail(int|string $id, array $columns = ['*'], array $options = []): Model
    {
        $query = $this->retrieveQuery($columns, $options);
        $this->withTrashed($query, $options);

        return $query->findOrFail($id);
    }


    /**
     * Retrieve all data where id in array from database.
     * @param array $ids
     * @param array $columns
     * @param array $options
     * @return Collection
     */
    public function retrieveByIds(array $ids, array $columns = ['*'], array $options = []): Collection
    {
        return $this->retrieveQuery($columns, $options)->whereIn($this->prefixTable('id'), $ids)->get();
    }

    /**
     * Find or fail by condition.
     * @param array $conditions
     * @param array $columns
     * @param bool $trashed
     * @return Model
     */
    public function findOrFailBy(array $conditions, array $columns = ['*'], array $options = []): Model
    {
        $query = $this->retrieveQuery($columns, $options);
        $this->withTrashed($query, $options);

        return $query->where($conditions)->firstOrFail();
    }

    /**
     * Find the given id.
     * @param int|string $id
     * @param array $columns
     * @param bool $trashed
     * @return Model|Collection|Repository|null
     */
    public function find(int|string $id, array $columns = ['*'], array $options = []): Model|Collection|null|static
    {
        $query = $this->retrieveQuery($columns, $options);
        $this->withTrashed($query, $options);

        return $query->find($id);
    }

    /**
     * Find the given slug or fail.
     * @param string $slug
     * @param array $columns
     * @param array $options
     * @return Model
     */
    public function findOrFailBySlug(string $slug, array $columns = ['*'], array $options = []): Model
    {
        $query = $this->retrieveQuery($columns, $options);
        $this->withTrashed($query, $options);

        return $query->where('slug_' . app()->getLocale(), $slug)->firstOrFail();
    }

    /**
     * Find by condition.
     * @param array $conditions
     * @param array $columns
     * @param array $options
     * @return Model|null
     */
    public function findBy(array $conditions, array $columns = ['*'], array $options = []): Model|null
    {
        $query = $this->retrieveQuery($columns, $options);

        if (method_exists($this->model, 'withTrashed')) {
            $this->withTrashed($query, $options);
        }

        return $query->where($conditions)->first();
    }


    /**
     * Find the given slug.
     * @param string $slug
     * @param array $columns
     * @param array $options
     * @return Model|null
     */
    public function findBySlug(string $slug, array $columns = ['*'], array $options = []): Model|null
    {
        $query = $this->select($columns);
        $this->withTrashed($query, $options);

        return $query->where('slug_' . app()->getLocale(), $slug)->first();
    }


    /**
     * Create new record.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Create new record.
     * @param array $data
     * @return Model
     */
    public function createMany(array $data): bool
    {
        return $this->model->insert($data);
    }

    /**
     * Update the given record id.
     * @param int|string $id
     * @param array $data
     * @return int
     *
     * @throws ModelNotFoundException
     */
    public function update(int|string $id, array $data): int
    {
        $model = $this->findOrFail($id);

        return $model->update($data, ['upsert' => true]);
    }

    /**
     * Update the given records ids.
     * @param array $ids
     * @param array $data
     * @return int
     */
    public function updateMany(array $ids, array $data): int
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->update($data);
    }

    /**
     * Update data by conditions.
     * @param array $conditions
     * @param array $data
     * @return int
     */
    public function updateBy(array $conditions, array $data): int
    {
        return $this->model->where($conditions)->update($data);
    }

    /**
     * Update data by slug.
     * @param string $slug
     * @param array $data
     * @return int
     */
    public function updateBySlug(string $slug, array $data): int
    {
        return $this->model->where('slug_' . app()->getLocale(), $slug)->update($data);
    }

    /**
     * Destroy the given record id.
     * @param int|string $id
     * @return boolean|null
     *
     * @throws ModelNotFoundException
     */
    public function destroy($id): ?bool
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }

    /**
     * Destroy the given records list ids.
     * @param array $ids
     * @return boolean
     */
    public function destroyMany(array $ids): bool
    {
        return $this->builder()->whereIn($this->model->getKeyName(), $ids)->delete();
    }

    /**
     * Restore the given record id.
     * @param int|string $id
     * @return boolean|null
     *
     * @throws ModelNotFoundException
     */
    public function restore($id): ?bool
    {
        $model = $this->findOrFail($id, [$this->model->getKeyName()], true);

        return $model->restore();
    }

    /**
     * Restore the given records list ids.
     * @param array $ids
     * @return boolean
     */
    public function restoreMany(array $ids): bool
    {
        return $this->builder()->whereIn($this->model->getKeyName(), $ids)->restore();
    }

    /**
     * Force Destroy the given record id.
     * @param int|string $id
     * @return boolean|null
     *
     * @throws ModelNotFoundException
     */
    public function forceDestroy($id): ?bool
    {
        $model = $this->findOrFail($id, [$this->model->getKeyName()], true);

        return $model->forceDelete();
    }

    /**
     * Force Destroy the given records list ids.
     * @param array $ids
     * @return boolean
     */
    public function forceDestroyMany(array $ids): bool
    {
        return $this->builder()->whereIn($this->model->getKeyName(), $ids)->forceDelete();
    }

    /**
     * @param Builder $query
     * @param $option
     * @return void
     */
    protected function withTrashed(Builder $query, $option): void
    {
        if (method_exists($this->model, 'withTrashed')) {
            $query->withTrashed($option['trashed'] ?? false);
        }
    }
}
