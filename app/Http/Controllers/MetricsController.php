<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Services\MetricsServices\IndividualMetrics;
use App\Services\MetricsServices\TrainingMetrics;
use Illuminate\Http\Request;

class MetricsController extends Controller {

    private $individualService;
    private $trainingService;

    public function __construct(IndividualMetrics $individualMetricsService, TrainingMetrics $trainingMetricService,  Request $request) {
        parent::__construct($request);
        $this->individualService = $individualMetricsService;
        $this->trainingService = $trainingMetricService;
    }

    /**
     * entry point
     *
     */
    public function metrics() {
        $this->dataForView['menuName'] = Defination::PAGE_METRICS;
        $selectedPosition = $this->dataForView['selectedPosition']->get('code');
        //metrics
        $this->dataForView['metrics'] = $this->individualService->get($selectedPosition);
        //training
        $this->dataForView['training'] = $this->trainingService->get($selectedPosition);
        return $this->render('pages.metrics');
    }
}
