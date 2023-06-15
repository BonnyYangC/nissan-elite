<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Helper\{Role, Utility};
use App\Models\{Position, User};

class UserService extends BaseService {

    /**
     * @return
     */
    public function load() {
        return User::select('users.id', 'employee_code', 'firstname', 'lastname', 'email', 'position_code', 'users.active', 'dealers.name', 'dealers.state')
            ->join('dealers', 'dealers.code', '=', 'users.dealer_code')
            ->where('users.active', 1)->paginate();
    }

    /**
     * @return mixed
     */
    public function loadRegionStaff() {
        return User::select('id', 'firstname', 'lastname', 'email', 'position_code', 'mobile', 'active', 'region_code')
            ->whereIn('position_code', $this->getRegionStaff())
            ->where('users.active', 1)->paginate();
    }

    /**
     * @return mixed
     */
    public function loadAdminUsers() {
        return User::select('id', 'firstname', 'lastname', 'email', 'mobile', 'region_code')
            ->where('position_code', 'ADMIN')
            ->where('users.active', 1)->paginate();
    }

    /**
     * @param array $regions
     * @param string $dept
     * @param null $dealerNameKeyword
     * @return mixed
     */
    public function loadActiveMember(array $regions, $dept = 'All', $dealerNameKeyword = null){
        $query = User::select('regions.title as region', 'dealers.code as dealer_code','dealers.name as dealer', 'users.employee_code',
            'users.firstname', 'users.lastname', 'positions.department as dept', 'positions.title as position',
            'users_eligible.registered', 'users.email', 'users.mobile')
            ->join('users_eligible','users.employee_code','=','users_eligible.employee_code')
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->join('positions', 'users.position_code', '=', 'positions.code')
            ->join('regions', 'regions.code', '=', 'dealers.region')
            ->whereIn('dealers.region', $regions)
            ->where('users.active', 1);

        if ($dept !== 'All') {
            $query = $query->where('positions.department', $dept);
        }
        if ($dealerNameKeyword) {
            $query = $query->where('dealers.name', 'LIKE', '%'.trim($dealerNameKeyword).'%');
        }

        return $query->get()->each(function($r) {
            $r['name'] = $r['firstname'] . ' ' . $r['lastname'];
            $r['registered'] = $r['registered'] ? 'YES' : 'NO';
        })->all();
    }

    /**
     * @param string $dealer
     * @param string $position
     * @param array $parameters
     * @return mixed
     */
    public function getTeamMembersByRole(string $dealer, string $position, array $parameters) {
        $parameters = $parameters ? $parameters : [
            'sortby' => 'firstname',
                'order' => 'asc'
            ];
        $membersPosition = $this->serviceResolver->positionService()->getMemberRoles($position);
        return User::select('users.id', 'firstname', 'lastname', 'positions.title', 'territory_reports.cr_ytd')
            ->join('dealers', 'dealers.code', '=', 'users.dealer_code')
            ->join('positions', 'positions.code', '=', 'users.position_code')
            ->join('territory_reports', 'territory_reports.employee_code', '=', 'users.employee_code')
            ->where('users.active', 1)
            ->where('dealers.code', $dealer)
            ->whereIn('position_code', $membersPosition)
            ->orderBy($parameters['sortby'], $parameters['order'])
            ->get();
    }

    /**
     * @param string $dealer
     * @param array $parameters
     * @return mixed
     */
    public function getTeamMembersByDealerCode(string $dealer, array $parameters = null) {
        $parameters = $parameters ? $parameters : [
            'sortby' => 'firstname',
            'order' => 'asc'
        ];
        return User::select('users.id', 'firstname', 'lastname', 'positions.title', 'territory_reports.cr_ytd')
            ->join('dealers', 'dealers.code', '=', 'users.dealer_code')
            ->join('positions', 'positions.code', '=', 'users.position_code')
            ->join('territory_reports', 'territory_reports.employee_code', '=', 'users.employee_code')
            ->where('users.active', 1)
            ->where('dealers.code', $dealer)
            ->orderBy($parameters['sortby'], $parameters['order'])
            ->get();
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function update($newData) {
        if(!empty($newData['id'])){
            $user = User::find($newData['id']);
        }else{
            $user = new User();
        }
        $user->firstname = $newData['firstname'];
        $user->lastname = $newData['lastname'];
        $user->email = $newData['email'];
        $user->mobile = $newData['mobile'];
        $user->active = intval($newData['active']);
        switch (true) {
            case !isset($newData['password']):
                return $user->save();
            case Utility::validatePassword($newData['password']):
                $user->password = bcrypt($newData['password']);
                return $user->save();
            default:
                return 'Invalidate Password';
        }
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function updateRegionStaff($newData) {
        if(!empty($newData['id'])){
            $user = User::find($newData['id']);
        }else{
            $user = new User();
        }
        $user->firstname = $newData['firstname'];
        $user->lastname = $newData['lastname'];
        $user->email = $newData['email'];
        $user->mobile = $newData['mobile'];
        $user->position_code = $newData['position'];
        $user->region_code = $newData['region'];
        $user->active = intval($newData['active']);
        switch (true) {
            case !isset($newData['password']):
                return $user->save();
            case Utility::validatePassword($newData['password']):
                $user->password = bcrypt($newData['password']);
                return $user->save();
            default:
                return 'Invalidate Password';
        }
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function updateAdminUser($newData) {
        if(!empty($newData['id'])){
            $user = User::find($newData['id']);
        }else{
            $user = new User();
            $user->position_code = 'ADMIN';
        }
        $user->firstname = $newData['firstname'];
        $user->lastname = $newData['lastname'];
        $user->email = $newData['email'];
        $user->mobile = $newData['mobile'];
        $user->active = intval($newData['active']);
        switch (true) {
            case !isset($newData['password']):
                return $user->save();
            case Utility::validatePassword($newData['password']):
                $user->password = bcrypt($newData['password']);
                return $user->save();
            default:
                return 'Invalidate Password';
        }
    }

    /**
     * @param User $user
     * @return bool|int|null
     * @throws \Exception
     */
    public function delete(User $user) {
        return $user->delete();
    }

    /**
     * @param string $keyWords
     * @return mixed
     */
    public function searchUser(string $keyWords) {
        $position = array_merge($this->getPositionsForSearch(), $this->getRegionStaff(), [Role::TRAINING]);
        $query = User::query();

        $query = $query->leftJoin('dealers', 'dealer_code', '=', 'code')
            ->select(['users.id', 'employee_code', 'email', 'firstname', 'lastname', 'position_code', 'users.active', 'dealers.name'])
            ->whereIn('position_code', $position)->where('users.active', 1);

        $keys = explode(' ', $keyWords,2);
        if (count($keys) > 1) {
            $query = $query->where('firstname', 'LIKE', '%'.trim($keys[0]).'%')
                ->where('lastname', 'LIKE', '%'.trim($keys[1]).'%');
        } else {
            $query = $query->where(function($query) use ($keys) {
                $query->orWhere('firstname', 'LIKE', '%' . trim($keys[0]) . '%')
                    ->orWhere('lastname', 'LIKE', '%' . trim($keys[0]) . '%')
                    ->orWhere('email', 'LIKE', '%' . trim($keys[0]) . '%')
                    ->orWhere('employee_code', 'LIKE', '%' . trim($keys[0]) . '%');
            });
        }
        return $query->get();
    }

    /**
     * @return mixed
     */
    public function getRegionStaffPositions() {
        return $this->serviceResolver->positionService()->loadRegionStaff();
    }

    /**
     * @return mixed
     */
    public function getRegions() {
        return $this->serviceResolver->regionService()->load();
    }

    /**
     * Get user positions
     *
     * @return array
     */
    private function getPositionsForSearch(): array {
        return [
            Role::RETAIL_SALES_CONSULTANTS,
            Role::FLEET_SALES_EXECUTIVES,
            Role::SALES_MANAGER,
            Role::SERVICE_ADVISERS,
            Role::STOCK_CONTROLLER,
            Role::PARTS_MANAGER,
            Role::PARTS_SALES_REP,
            Role::SERVICE_MANAGER,
            Role::FI,
        ];
    }

    /**
     * Get region staff positions
     *
     * @return array
     */
    private function getRegionStaff(): array {
        return Position::REGION_STAFF_POSITIONS;
    }
}
