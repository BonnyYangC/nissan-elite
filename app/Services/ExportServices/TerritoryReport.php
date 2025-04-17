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
        $regions = (in_array($admin->position_code, ['ADMIN']) || in_array($admin->region->code, ['H', 'NFSA', 'DESTINATION'])) ? [
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
            'APR '.config('app.theme') => 'c04',
            'MAY '.config('app.theme') => 'c05',
            'JUN '.config('app.theme') => 'c06',
            'JUL '.config('app.theme') => 'c07',
            'AUG '.config('app.theme') => 'c08',
            'SEP '.config('app.theme') => 'c09',
            'OCT '.config('app.theme') => 'c10',
            'NOV '.config('app.theme') => 'c11',
            'DEC '.config('app.theme') => 'c12',
            'JAN '.(config('app.theme')+1) => 'c01',
            'FEB '.(config('app.theme')+1) => 'c02',
            'MAR '.(config('app.theme')+1) => 'c03',
            'Point YTD Historical' => 'pys',
        ];

        return Utility::exportToFile('territory_report_'.$today->format('d_M_Y').'.csv', $report, $contentMap);
    }

}
