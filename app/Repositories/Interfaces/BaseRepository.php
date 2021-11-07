<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepository
{
    /**
     * @param int $id
     * @param array|null $with
     * @param array|null $order
     * @param array $columns
     *
     * @return Model|null
     */
    public function find(int $id, array $with = null, array $order = null, array $columns = ['*']): ?Model;

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param array $data
     * @param array $conditions
     *
     * @return bool
     */
    public function update(array $data, array $conditions): bool;

    /**
     * @param int $perPage
     * @param array $columns
     * @param array|null $with
     * @param null $modifyQuery
     * @param array|null $order
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], ?array $with = null, $modifyQuery = null, array $order = null): LengthAwarePaginator;

    /**
     * @param array $columns
     * @param array|null $with
     * @param null $modifyQuery
     * @param array|null $order
     */
    public function all(array $columns = ['*'], ?array $with = null, $modifyQuery = null, array $order = null);


    /**
     * @param array $ids
     *
     * @return bool|null
     */
    public function bulkDelete(array $ids): ?bool;

    /**
     * @param array $conditions
     *
     * @return bool|null
     */
    public function delete(array $conditions): ?bool;
}
