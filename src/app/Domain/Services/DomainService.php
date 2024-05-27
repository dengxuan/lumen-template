<?php

namespace App\Domain\Services;

use App\Domain\Services\Abstractions\IDomainService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Repository.
 *
 * @template TModel of Model
 */
abstract class DomainService implements IDomainService
{
    /**
     * @var class-string<TModel>
     */
    protected string $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query()
    {
        return call_user_func($this->model . '::query');
    }

    /**
     * Perform a join query.
     *
     * @param string $table The table to join
     * @param string $first The first column to join on
     * @param string $operator The operator for the join
     * @param string $second The second column to join on
     * @param string $type The type of join (e.g., inner, left, right)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function join(string $table, string $first, string $operator, string $second, string $type = 'inner'): Builder
    {
        return $this->query()->join($table, $first, $operator, $second, $type);
    }

    /**
     * Create a new record.
     * 
     * @param array $attributes
     * @return TModel
     */
    public function create(array $attributes)
    {
        return $this->query()->create($attributes);
    }

    /**
     * Update a record.
     * 
     * @param $id
     * @param array $attributes
     * @return int
     */
    public function update($id, array $attributes)
    {
        return $this->query()->where('id', $id)->update($attributes);
    }

    /**
     * Delete a record.
     * 
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Delete all records.
     */
    public function deleteAll()
    {
        return $this->query()->delete();
    }

    /**
     * Get all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection<TModel>
     */
    public function all()
    {
        return $this->query()->get();
    }

    /**
     * Count the number of records.
     * 
     * @return int
     */
    public function count()
    {
        return $this->query()->count();
    }

    /**
     * Paginate the given query.
     *
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->query()->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Get the first record.
     * 
     * @return TModel
     */
    public function first()
    {
        return $this->query()->first();
    }

    /**
     * Find a object by its primary key.
     * 
     * @param $id
     *
     * @return TModel
     */
    public function find($id)
    {
        return $this->query()->find($id);
    }

    /**
     * Find a object by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[]
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function get($id)
    {
        return $this->query()->findOrFail($id);
    }
}