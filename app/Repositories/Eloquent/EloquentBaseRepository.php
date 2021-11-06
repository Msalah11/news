<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class EloquentBaseRepository implements BaseRepository
{
    /**
     * Model An instance of the Eloquent Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @param array|null $with
     * @param array|null $order
     * @param array|string[] $columns
     *
     * @return Model|null
     */
    public function find(int $id, array $with = null, array $order = null, array $columns = ['*']): ?Model
    {
        $query = $this->model->newQuery();
        $this->processQuery($query, $with, $order);

        return $query->find($id, $columns);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param array $conditions
     *
     * @return bool
     */
    public function update(array $data, array $conditions): bool
    {
        return $this->model->where($conditions)->update($data);
    }

    /**
     * @param int $perPage
     * @param array|string[] $columns
     * @param array|null $with
     * @param null $modifyQuery
     * @param array|null $order
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], ?array $with = null, $modifyQuery = null, array $order = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        $this->processQuery($query, $with, $order);

        if (!is_null($modifyQuery)) {
            is_array($modifyQuery) ? $query = $query->where($modifyQuery) : $modifyQuery($query);
        }

        return $query->paginate($perPage, $columns);
    }

    public function delete(array $conditions): ?bool
    {
        return $this->model->where($conditions)->delete();
    }

    protected function processQuery($query, $with = null, $order = null)
    {
        if ($with) {
            $query->with($with);
        }

        if ($order && is_array($order)) {
            foreach ($order as $key => $sort) {
                $query->orderBy($key, $sort);
            }
        }
    }
}
