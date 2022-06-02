<?php

namespace App\Http\Controllers;

use App\Helper\JsonBuilder;
use App\Services\DataService;
use Illuminate\Http\Request;

class RegionController extends Controller {

    /** @var DataService  */
    private $dataService;

    /**
     * Create a new controller instance.
     * @param DataService $dataService
     * @return void
     */
    public function __construct(DataService $dataService, Request $request) {
        parent::__construct($request);
        $this->dataService = $dataService;
    }

    public function load_report(Request $request) {
        $region = $request->input('region');
        $rows = $this->dataService->loadTerritoryReport([$region]);
       echo JsonBuilder::Success($rows);
    }
}
