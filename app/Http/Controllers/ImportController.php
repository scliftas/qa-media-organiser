<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImportService;
use App\Http\Requests\ImportRequest;
use Auth;
use App\Http\Resources\FileResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PlaylistResource;

class ImportController extends Controller
{
    protected $import_service;

    public function __construct(ImportService $import_service) {
        $this->import_service = $import_service;
    }

    public function upload(ImportRequest $request) {
        $data = $this->import_service->run($request->all(), Auth::user()->id);

        return [
            'files' => FileResource::collection($data['files'])->resolve(),
            'categories' => CategoryResource::collection($data['categories'])->resolve(),
            'playlists' => PlaylistResource::collection($data['playlists'])->resolve()
        ];
    }
}