<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Services\DataServices\DataExportService;
use Illuminate\Http\Request;

class DataExportController extends Controller
{
    /** @var DataExportService  */
    private $service;

    public function __construct(DataExportService $dataExportService, Request $request) {
        parent::__construct($request);
        $this->service = $dataExportService;
    }

    public function data_export(Request $request, string $type) {
        return $this->service->export($type, $request->input());
    }
}
