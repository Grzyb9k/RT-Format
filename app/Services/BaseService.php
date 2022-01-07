<?php

namespace App\Services;

abstract class BaseService
{
    protected $repository;
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $columns = ['*'], array $relations = [])
    {
        return $this->repository->all($columns, $relations);
    }
    public function getAllPaginated(array $relations = [], $request)
    {
        return $this->repository->allPaginated($relations, $request);
    }
    public function getOne(int $id)
    {
        return $this->repository->findById($id);
    }
}
