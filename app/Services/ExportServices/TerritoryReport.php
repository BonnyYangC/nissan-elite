<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use App\Models\User;
use App\Services\BaseService;
use App\Services\ServiceResolver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TerritoryReport extends BaseService {
    private $parameters;

    /**
     * Create a new service instance.
     *
     * @param ServiceResolver $serviceResolver
     * @param $parameters
     */
    public function __construct(ServiceResolver $serviceResolver, $parameters) {
        parent::__construct($serviceResolver);
        $this->parameters = $parameters;
    }

    /**
     *
     */
    public function export() {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        /** @var User $admin */
        $admin = Auth::user();
        $regions = ($admin->position_code === 'ADMIN' || $admin->region->code === 'H' || $admin->region->code === 'NFSA') ? [
            'E', 'N', 'S', 'W'
        ] : [$admin->region->code];
        $dept = isset($this->parameters['dept']) ? $this->parameters['dept'] : 'All';
        $dealer = isset($this->parameters['dealer']) ? $this->parameters['dealer'] : null;
        $report = $this->serviceResolver->territoryReportService()->load($regions, $dept, $dealer);
        $contentMap = [
            'Region' => 'region',
            'Dealer' => 'd',
            'Registered' => 'c',
            'Dept' => 's',
            'Name' => 'f',
            'Member No.' => 'e',
            'Position' => 'p',
            'YTD' => 'y',
            'Award Status' => 'as',
            'APR '.config('elite.YEAR') => 'c04',
            'MAY '.config('elite.YEAR') => 'c05',
            'JUN '.config('elite.YEAR') => 'c06',
            'JUL '.config('elite.YEAR') => 'c07',
            'AUG '.config('elite.YEAR') => 'c08',
            'SEP '.config('elite.YEAR') => 'c09',
            'OCT '.config('elite.YEAR') => 'c10',
            'NOV '.config('elite.YEAR') => 'c11',
            'DEC '.config('elite.YEAR') => 'c12',
            'JAN '.(config('elite.YEAR')+1) => 'c01',
            'FEB '.(config('elite.YEAR')+1) => 'c02',
            'MAR '.(config('elite.YEAR')+1) => 'c03',
            'Point YTD Historical' => 'pys',
        ];

        return Utility::exportToFile('territory_report_'.$today->format('d_M_Y').'.csv', $report, $contentMap);
    }

}
