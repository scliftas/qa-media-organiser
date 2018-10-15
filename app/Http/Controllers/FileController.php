<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Http\Requests\GetFilesRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use Auth;

class FileController extends Controller
{
    protected $file_service;

    public function __construct(FileService $file_service) {
        $this->file_service = $file_service;
    }

    public function get(GetFilesRequest $request) {
        $files = $this->file_service->all();
        return FileResource::collection($files->where('user_id', Auth::user()->id))->resolve();
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

    public function update(UpdateFileRequest $request) {
        return new FileResource($this->file_service->update($request->all()));
    }
}
