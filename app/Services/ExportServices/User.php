<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use App\Services\BaseService;
use App\Services\ServiceResolver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class User extends BaseService {
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
        $admin = Auth::user();
        $regions = ($admin->position_code === 'ADMIN' || $admin->region->code === 'H' || $admin->region->code === 'NFSA') ? [
            'E', 'N', 'S', 'W'
        ] : [$admin->region->code];
        $dept = isset($this->parameters['dept']) ? $this->parameters['dept'] : 'All';
        $dealer = isset($this->parameters['dealer']) ? $this->parameters['dealer'] : null;
        $users = $this->serviceResolver->userService()->loadActiveMember($regions, $dept, $dealer);
        $contentMap = [
            'Region Code' => 'region',
            'Dealer Code' => 'dealer_code',
            'Dealer' => 'dealer',
            'Registration No.' => 'employee_code',
            'Name' => 'name',
            'Dept' => 'dept',
            'Position' => 'position',
            'Registered' => 'registered',
            'email' => 'email',
            'mobile' => 'mobile'
        ];

        return Utility::exportToFile('active_member_list_'.$today->format('d_M_Y').'.csv', $users, $contentMap);
    }

}
