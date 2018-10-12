<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\Image;

class ImageRepository extends AbstractRepository {
    public function __construct(Image $image) {
        parent::__construct($image);
    }

    public function updateOrCreate($data) {
        $image = [
            'file_id' => $data['file_id'],
            'name' => $data['image']->getClientOriginalName(),
            'blob' => file_get_contents($data['image']->getRealPath())
        ];

        return $this->model->updateOrCreate($image);
    }
}