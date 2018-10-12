<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface {
    public function all();

    public function create($data);

    public function update($data, $id);

    public function delete($id);

    public function get($id);
}