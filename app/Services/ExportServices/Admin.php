<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use App\Models\User;
use Carbon\Carbon;

class Admin {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     *
     */
    public function export() {
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $admins = User::where('position_code', 'ADMIN')->get();
        $admins->each(function($a) {
            $a->region = 'All Regions';
        });
        $contentMap = [
            'Region' => 'region',
            'Firstname' => 'firstname',
            'Surname' => 'lastname',
            'Email' => 'email',
            'Password' => 'password',
            'Mobile' => 'mobile'
        ];

        return Utility::exportToFile('nissan_admins_'.$today->format('d_M_Y').'.csv', $admins, $contentMap);
    }

}
