<?php

namespace App\Http\Controllers;

use App\Services\MetricsService;
use App\Services\PagesService;
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
/*var_dump($currentUser->results()->pluck('metrics', 'period'));
$this->dataForView['metricData'] = [
    'title' => '1. metrics test title',
    'chart_name' => 'metric-chart',
    'chart_data' => json_encode([['Month', 'Points'], ['Apr', 100], ['May', 100], ['Jun', 100], ['Jul', 100], ['Aug', 100], ['Sep', 100], ['Oct', 100], ['Nov', 100], ['Dec', 100]]),

    'table_data' => ['RESULT' => ['100','100','100','100','100','100','100','100','100','100','100','100']],
    'extra_class' => '',
    'ref' => 'test ref string',
    'guides' => [[
        'title' => 'MATCHED ORDER WRITE GUIDE',
        'top' => ['Sales Manager', '0 or 1 unit Variation', '2 unit Variation', '3 unit Variation'],
        'rows' => [['Category A', 310, 105, 105], ['Category B', 310, 105, 105], ['Category C', 310, 105, '']]
    ]]
];*/
        return $this->render('pages.metrics');
    }
}
