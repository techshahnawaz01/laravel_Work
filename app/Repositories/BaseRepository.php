<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    /**
     * The model instance.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Create a new repository instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all records.
     *
     * @return Collection<int, Model>
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a record by its ID.
     *
     * @param string $id
     * @return Model|null
     */
    public function findById(string $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Paginate the results.
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }
}
