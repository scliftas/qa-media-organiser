<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\Category;

class CategoryRepository extends AbstractRepository {
    public function __construct(Category $category) {
        parent::__construct($category);
    }   

    public function delete($id) {
        $category = $this->get($id);
        $category->files()->detach();

        return parent::delete($id);
    }
}