<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExportService;
use Auth;
use App\Http\Resources\ExportResource;

class ExportController extends Controller
{
    protected $export_service;

    public function __construct(ExportService $export_service) {
        $this->export_service = $export_service;
    }

    public function generate() {
        return ExportResource::collection($this->export_service->generateForUser(Auth::user()->id))->resolve();
    }
}