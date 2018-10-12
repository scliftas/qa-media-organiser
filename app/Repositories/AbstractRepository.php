<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface {
    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model->all();
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($data, $id) {
        $model = $this->find($id);
        return $model->update($data);
    }

    public function delete($id) {
        return $this->model->destroy($id);
    }

    public function get($id) {
        return $this->model->findOrFail($id);
    }

    public function getWith($id, $relations) {
        return $this->model->with($relations)->findOrFail($id);
    }
}