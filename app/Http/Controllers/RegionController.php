<?php

namespace App\Http\Controllers;

use App\Helper\JsonBuilder;
use App\Services\ServiceResolver;
use Illuminate\Http\Request;

class RegionController extends Controller {

    /** @var ServiceResolver  */
    private $resolver;

    /**
     * DashboardController constructor.
     * @param ServiceResolver $resolver
     * @param Request $request
     */
    public function __construct(ServiceResolver $resolver, Request $request) {
        parent::__construct($request);
        $this->resolver = $resolver;
    }

    /**
     * @param Request $request
     */
    public function load_report(Request $request) {
        $region = $request->input('region');
        $rows = $this->resolver->territoryReportService()->load([$region]);
        echo JsonBuilder::Success($rows);
    }
}

