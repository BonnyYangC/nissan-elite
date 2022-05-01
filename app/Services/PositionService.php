<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\Position;

class PositionService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return
     */
    public function load() {
        return Position::whereIn('department', ['Sales', 'Parts', 'Service', 'Administration'])->get();
    }

    /**
     * @return
     */
    public function loadRegionStaff() {
        return Position::whereIn('code', Position::REGION_STAFF_POSITIONS)->get();
    }

    /**
     * Get member roles by given position
     * @param  string $position
     * @return array
     */
    public function getMemberRoles($position = null){
        $result = [];

        switch ($position){
            case Role::PARTS_MANAGER:
                $result = [Role::PARTS_SALES_REP];
                break;
            case Role::SERVICE_MANAGER:
                $result = [Role::SERVICE_ADVISERS];
                break;
            case Role::SALES_MANAGER:
                $result = [Role::RETAIL_SALES_CONSULTANTS,Role::FLEET_SALES_EXECUTIVES];
                break;
            default:
                break;
        }
        return $result;
    }
}
