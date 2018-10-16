<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\Image;
use Storage;

class ImageRepository extends AbstractRepository {
    public function __construct(Image $image) {
        parent::__construct($image);
    }

    public function updateOrCreate($file, $file_id) {
        $file_name = $file->getClientOriginalName();

        if (Storage::disk('local')->put($file_name, file_get_contents($file->getRealPath()))) {
            $this->model->where('file_id', $file_id)->delete();

            return $this->model->updateOrCreate([
                'file_id' => $file_id,
                'name' => $file->getClientOriginalName(),
                'path' => Storage::disk('local')->path($file_name)
            ]);
        }
        
    }

    public function createFromBlob($data) {
        if (Storage::disk('local')->put($data->name, base64_decode($data->blob))) {
            $file = [
                'file_id' => $data->file_id,
                'name' => $data->name,
                'path' => Storage::disk('local')->path($data->name)
            ];
            
            return $this->model->updateOrCreate($file);
        }

        return false;
    }
}