<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImportService;
use App\Http\Requests\ImportRequest;
use Auth;

class ImportController extends Controller
{
    protected $import_service;

    public function __construct(ImportService $import_service) {
        $this->import_service = $import_service;
    }

    public function upload(ImportRequest $request) {
        return $this->import_service->run($request->all(), Auth::user()->id);
    }
}