<?php

namespace App\Http\Controllers;

use App\Services\MetricsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetricsController extends Controller {

    /** @var MetricsService  */
    private $service;

    /**
     * MetricsController constructor.
     * @param MetricsService $service
     * @param Request $request
     */
    public function __construct(MetricsService $service, Request $request) {
        parent::__construct($request);
        $this->service = $service;
    }

    /**
     * entry point
     *
     */
    public function metrics() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'metrics';
        //metrics
        $this->dataForView['metrics'] = $this->service->getMetricsData();
        //training
        $this->dataForView['training'] = $this->service->getTrainingData();
        return $this->render('pages.metrics');
    }
}
