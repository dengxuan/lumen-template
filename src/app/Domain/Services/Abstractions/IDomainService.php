<?php

namespace App\Domain\Services\Abstractions;

/**
 * Interface IDomainService.
 */
interface IDomainService
{

    /**
     * Create a new record.
     * 
     * @param array $attributes
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes);

    /**
     * Update a record.
     * 
     * @param int $id
     * @param array $attributes
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $attributes);

    /**
     * Delete a record.
     */
    public function delete($id);

    /**
     * Delete all records.
     */
    public function deleteAll();

    /**
     * Count the number of records.
     * 
     * @return int
     */
    public function count();

    /**
     * Get all records.
     */
    public function all();

    /**
     * Find a object by its primary key.
     */
    public function find($id);

    /**
     * Get the first record.
     */
    public function first();

    /**
     * Find a object by its primary key or throw an exception.
     */
    public function get($id);

    /**
     * Get records by page.
     * 
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * 
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null);
}