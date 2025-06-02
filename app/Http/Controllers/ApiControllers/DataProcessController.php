<?php

namespace App\Http\Controllers\ApiControllers;

use App\Helper\Defination;
use App\Http\Controllers\Controller;
use App\Services\DataServices\DataProcessService;
use Illuminate\Http\Request;

class DataProcessController extends Controller
{
    /** @var DataProcessService  */
    private $service;

    public function __construct(DataProcessService $dataProcessService, Request $request) {
        parent::__construct($request);
        $this->service = $dataProcessService;
    }

    public function data_process(Request $request) {

        $actionType = $request->input('action_type');
        $dataType = $request->input('for');
        
        if ($request->hasFile('file')) {
            $dataFile = $request->file->storeAS('file', $dataType.date('Y-m-d').'.csv', 'public');
            if($actionType == Defination::ACTION_TYPE_SYNC){
                $this->dataForView['result'] = $this->service->importation($dataFile, $dataType);
            }else{
                $this->dataForView['result'] = $this->service->validation($dataFile, $dataType);
            }

        }
        return $this->render('pages.backend.resulting');
    }
}
