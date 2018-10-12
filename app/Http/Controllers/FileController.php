<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Http\Requests\UploadFileRequest;
use App\Http\Resources\FileResource;

class FileController extends Controller
{
    protected $file_service;

    public function __construct(FileService $file_service) {
        $this->file_service = $file_service;
    }

    public function upload(UploadFileRequest $request) {
        $uploaded_files = [];

        foreach ($request->files as $files) {
            foreach ($files as $file) {
                array_push($uploaded_files, $this->file_service->create($file));
            }
        }

        $uploaded_files = collect($uploaded_files);

        return FileResource::collection($uploaded_files)->resolve();
    }
}
