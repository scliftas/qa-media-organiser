<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\File;
use Storage;
use Auth;

class FileRepository extends AbstractRepository {
    public function __construct(File $file) {
        parent::__construct($file);
    }

    public function create($file) {
        $file_name = $file->getClientOriginalName();

        if (Storage::disk('local')->put($file_name, file_get_contents($file->getRealPath()))) {
            return $this->model->create([
                'user_id' => Auth::user()->id,
                'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'type' => $file->getClientOriginalExtension(),
                'path' => Storage::disk('local')->path($file_name)
            ]);
        }
        
        return false;
    }

    public function createFromBlob($data) {
        $file_name = $data->name . '.' . $data->type;

        if (Storage::disk('local')->put($file_name, base64_decode($data->blob))) {
            $file = [
                'user_id' => Auth::user()->id,
                'name' => $data->name,
                'type' => $data->type,
                'path' => Storage::disk('local')->path($file_name)
            ];

            if (property_exists($data, 'comment')) $file['comment'] = $data->comment;
            
            return $this->model->updateOrCreate($file);
        }

        return false;
    }

    public function delete($id) {
        $file = parent::get($id);
        if (Storage::disk('local')->delete($file->name . '.' . $file->type)) return parent::delete($id);
        return false;
    }
}