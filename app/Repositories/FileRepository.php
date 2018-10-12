<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\File;
use Auth;
use DB;

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
}