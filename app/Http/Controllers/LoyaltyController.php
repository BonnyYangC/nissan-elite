<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Services\GageServices\Loyalty;
use App\Services\{LoyaltyService, ResultService};
use Illuminate\Http\Request;

class LoyaltyController extends Controller {

    private $resultService;
    private $loyaltyService;

    public function __construct(ResultService $resultService, LoyaltyService $loyaltyService, Request $request) {
        parent::__construct($request);
        $this->resultService = $resultService;
        $this->loyaltyService = $loyaltyService;
    }

    public function loyalty() {
        $this->dataForView['menuName'] = Defination::PAGE_LOYALTY;
        $selectedPosition = $this->dataForView['selectedPosition']->get('code');
        $ytd = $this->resultService->getYearToDateData($selectedPosition);
        $historical = $this->loyaltyService->buildLoyaltyData($ytd ?? 0);

        (new Loyalty())->loyalty_status_level(floatval($historical['total'])/* + floatval($ytd)*/);

        //year to date
        // $this->dataForView['ytd'] = $ytd;
        $this->dataForView['historical'] = $historical;
        return $this->render('pages.loyalty');
    }
}
