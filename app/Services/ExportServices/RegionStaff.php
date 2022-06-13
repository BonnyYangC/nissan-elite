<?php

namespace App\Services\ExportServices;

use App\Helper\Utility;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;

class RegionStaff {

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
        $region_staff = User::whereIn('position_code', Position::REGION_STAFF_POSITIONS)->get();
        $region_staff->each(function($a) {
            $a->region = $a->region->title;
            $a->active = $a->active ? 'YES' : 'NO';
        });
        $contentMap = [
            'Region' => 'region',
            'Firstname' => 'firstname',
            'Surname' => 'lastname',
            'Email' => 'email',
            'Position' => 'position_code',
            'Mobile' => 'mobile',
            'Active' => 'active'
        ];

        return Utility::exportToFile('nissan_region_staff_'.$today->format('d_M_Y').'.csv', $region_staff, $contentMap);
    }

}
