<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Http\Requests\GetFilesRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\DownloadFileRequest;
use App\Http\Requests\DeleteFileRequest;
use App\Http\Requests\MoveFileRequest;
use App\Http\Resources\FileResource;
use Auth;
use Storage;

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
        $data = $request->all();
        $files = new FileResource($this->file_service->update($data));
        return $files->resolve();
    }

    public function download(DownloadFileRequest $request) {
        $file_id = $request->input('id');
        $file = $this->file_service->get($file_id);
        return Storage::disk('local')->get($file->name . '.' . $file->type);
    }

    public function delete(DeleteFileRequest $request) {
        $file_id = $request->input('id');
        return $this->file_service->delete($file_id);
    }

    public function moveFileDown(MoveFileRequest $request) {
        $data = $request->all();
        return FileResource::collection($this->file_service->moveFileDown($data)->where('user_id', Auth::user()->id))->resolve();
    }
}
