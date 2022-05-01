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
//var_dump($rows->toArray());
//dd();
        /*$regions = explode(' ',$this->request->param('regions'));
        $rows = $this->_retrieve_regional_data($regions[0]);

        for($i = 0;$i<count($rows);$i++){
            $rows[$i]['p'] = RegionTerritoryReport::ShortenPositionString($rows[$i]['p']);
            $rows[$i]['c'] = $rows[$i]['c']=='Registered'? 'YES':'NO';
        }*/
       echo JsonBuilder::Success($rows);
    }
}
