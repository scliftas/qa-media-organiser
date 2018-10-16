<?php

namespace App\Services;

use App\Models\File;
use App\Repositories\FileRepository;
use Storage;

class ExportService {
    protected $file_repository;

    public function __construct(File $file) {
        $this->file_repository = new FileRepository($file);
    }

    public function generateForUser($user_id) {
        $files = $this->file_repository->allWith(['categories', 'playlists', 'image'])->where('user_id', $user_id)->get();

        foreach ($files as $file) {
            $file->blob = base64_encode(Storage::disk('local')->get($file->name . '.' . $file->type));
            
            if ($file->image && $file->image->name) $file->image->blob = base64_encode(Storage::disk('local')->get($file->image->name));
        }

        return $files;
    }
}