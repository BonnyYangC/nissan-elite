<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Services\GageServices\Loyalty;
use App\Services\ServiceResolver;
use Illuminate\Http\Request;

class LoyaltyController extends Controller {

    /** @var ServiceResolver  */
    private $resolver;

    /**
     * Create a new controller instance.
     * @param ServiceResolver $resolver
     * @return void
     */
    public function __construct(ServiceResolver $resolver, Request $request) {
        parent::__construct($request);
        $this->resolver = $resolver;
    }

    public function loyalty() {
        $this->dataForView['menuName'] = Defination::PAGE_LOYALTY;
        $selectedPosition = $this->dataForView['selectedPosition']->get('code');
        $ytd = $this->resolver->resultService()->getYearToDateData($selectedPosition);
        $historical = $this->resolver->historicalService()->getHistoricalData();
        // $this->resolver->gageService()->loyalty_status_level(floatval($historical['total']) + floatval($ytd));
        (new Loyalty())->loyalty_status_level(floatval($historical['total']) + floatval($ytd));

        //year to date
        $this->dataForView['ytd'] = $ytd;
//new UserResource($user);
        //historical points   
        $year = date('y', strtotime(config('app.theme').'-01-01'));
        $historical['all'] = array_merge([
            'FY'.$year.' YTD' => number_format($ytd, 0)
        ], $historical['all']);
        $this->dataForView['historical'] = $historical;
        return $this->render('pages.loyalty');
    }
}
