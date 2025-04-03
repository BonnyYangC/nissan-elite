<?php

namespace App\Services;

use App\Repositories\{PositionRepository, RegionRepository};
use App\Helper\{Role, Utility};
use App\Models\{Position, User};

class UserService extends BaseService {

    private $regionRepo;
    private $positionRepo;

    /**
     * Create a new service instance.
     *
     * @param ServiceResolver $serviceResolver
     * @return void
     */
    public function __construct(ServiceResolver $serviceResolver, RegionRepository $regionRepository, PositionRepository $positionRepository) {
        parent::__construct($serviceResolver);
        $this->regionRepo = $regionRepository;
        $this->positionRepo = $positionRepository;
    }

    /**
     * @return
     */
    public function load() {
        return User::activeMember()->paginate();
    }

    /**
     * @return mixed
     */
    public function loadRegionStaff() {
        return User::regionStaff()->paginate();
    }

    /**
     * @return mixed
     */
    public function loadAdminUsers() {
        return User::admin()->paginate();
    }

    /**
     * @param array $regions
     * @param string $dept
     * @param null $dealerNameKeyword
     * @return mixed
     */
    public function loadActiveMember(array $regions, $dept = 'All', $dealerNameKeyword = null){
        $query = User::where('users.active', 1)
            ->joinUserEligible()
            ->join('dealers', 'users.dealer_code', '=', 'dealers.code')
            ->joinDealerRegions($regions)
            ->join('positions', 'users.position_code', '=', 'positions.code')
            ->join('regions', 'regions.code', '=', 'dealer_regions.region')
            ->select('users.employee_code', 'users.firstname', 'users.lastname', 'users.email', 'users.mobile', 'users_eligible.registered',
        'dealers.code as dealer_code','dealers.name as dealer',
        'positions.department as dept', 'positions.title as position',
        'regions.title as region');

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
        $membersPosition = $this->positionRepo->getMemberRoles($position);
        return User::select('users.id', 'firstname', 'lastname', 'positions.title', 'territory_reports.cr_ytd')
            ->join('dealers', 'dealers.code', '=', 'users.dealer_code')
            ->join('positions', 'positions.code', '=', 'users.position_code')
            ->join('territory_reports', 'territory_reports.employee_code', '=', 'users.employee_code')
            ->where('users.active', 1)
            ->where('dealers.code', $dealer)
            ->whereIn('position_code', $membersPosition)
            ->where('territory_reports.year', config('view.theme'))
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
            ->where('territory_reports.year', config('view.theme'))
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
        $position = array_merge(Position::SEARCHABLE_POSITIONS, Position::TECHNICIAN_POSITIONS, Position::REGION_STAFF_POSITIONS, [Role::TRAINING]);
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
        return $this->positionRepo->loadRegionStaff();
    }

    /**
     * @return mixed
     */
    public function getRegions() {
        return $this->regionRepo->load();
    }
}
