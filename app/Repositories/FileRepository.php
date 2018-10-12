<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\File;
use Auth;

class FileRepository extends AbstractRepository {
    public function __construct(File $file) {
        parent::__construct($file);
    }

    public function create($file) {
        $data = [
            'user_id' => Auth::user()->id,
            'name' => $file->getClientOriginalName(),
            'type' => $file->getClientOriginalExtension(),
            'blob' => file_get_contents($file->getRealPath())
        ];

        return parent::create($data);
    }
}