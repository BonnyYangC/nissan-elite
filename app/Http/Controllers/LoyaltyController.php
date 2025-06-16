<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Services\GageServices\Loyalty;
use App\Services\{HistoricalService, ResultService, ServiceResolver};
use Illuminate\Http\Request;

class LoyaltyController extends Controller {

    private $resultService;
    private $historicalService;

    public function __construct(ResultService $resultService, HistoricalService $historicalService, Request $request) {
        parent::__construct($request);
        $this->resultService = $resultService;
        $this->historicalService = $historicalService;
    }

    public function loyalty() {
        $this->dataForView['menuName'] = Defination::PAGE_LOYALTY;
        $selectedPosition = $this->dataForView['selectedPosition']->get('code');
        // $ytd = $this->resultService->getYearToDateData($selectedPosition);
        $historical = $this->historicalService->getHistoricalData();

    (new Loyalty())->loyalty_status_level(floatval($historical['total'])/* + floatval($ytd)*/);

        //year to date
        // $this->dataForView['ytd'] = $ytd;
        $this->dataForView['historical'] = $historical;
        return $this->render('pages.loyalty');
    }
}
