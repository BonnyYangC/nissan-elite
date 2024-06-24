<?php

namespace App\Repositories;

use App\Helper\Role;
use App\Models\Position;

class PositionRepository {

    /**
     * @return
     */
    public function loadMembers() {
        return Position::members()->get();
    }

    public function loadMembersWithT() {
        return Position::membersWithT()->get();
    }

    /**
     * @return
     */
    public function loadRegionStaff() {
        return Position::regionStaffs()->get();
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
