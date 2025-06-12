<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class User {
    
    use Exporter;
    private $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    /**
     *
     */
    public function export() {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $admin = Auth::user();
        $regions = (in_array($admin->position_code, ['ADMIN']) || in_array($admin->region->code, ['H', 'NFSA', 'DESTINATION'])) ? [
            'E', 'N', 'S', 'W'
        ] : [$admin->region->code];
        $dept = isset($this->parameters['dept']) ? $this->parameters['dept'] : 'All';
        $dealer = isset($this->parameters['dealer']) ? $this->parameters['dealer'] : null;
        $users = $this->service->loadActiveMember($regions, $dept, $dealer);
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
