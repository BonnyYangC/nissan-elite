<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\{Ranking, User};
use App\Models\Position;
use App\Services\RankingServices\Individual;
use App\Services\RankingServices\Technician;
use App\Services\StatusServices\GageStatus;
use App\ValueObjects\RankingValueObject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RankingService extends BaseService {

    public function getRankingService(Request $request) {
        $role = $request->input('role');
        $action = $request->input('action');
        $awardType = $request->input('type');
        $valueObject = new RankingValueObject($role, $action, $awardType);
        switch($role) {
            case Role::TECHNICIAN:
                return new Technician($valueObject);
            default:
                return new Individual($valueObject);
        }
    }

    // get ranking of current user
    // user may has multiple positions, so need $positionCode
    public function getRankingOfCurrentUser(string $positionCode, string $awardType = Ranking::AWARD_STATUS) {
        $currentPeriod = $this->getCurrentPeriod($positionCode);
        return Ranking::getRankingByEmployeeCode($this->currentUser->employee_code, $currentPeriod, $awardType)->first();
    }

    // user may has multiple positions, so need $positionCode
    public function getCurrentPeriod(string $positionCode): string {
        /** @var User $currentUser */
        $currentUser = $this->getCurrentUser();
        $currentPeriod = Ranking::getMaxPeriod($currentUser->employee_code, $positionCode);
        if (!$currentPeriod) {
            $thisPeriod = date('Y-m').'-01';
            $currentPeriod = Carbon::createFromFormat('Y-m-d',$thisPeriod)->format('Y-m-d');
        }
        return $currentPeriod;
    }

    public function getRankingDataByPosition(string $positionCode): array {
        // 获取了所有的 Rankings: Get all rankings
        if(in_array($positionCode, Position::TECHNICIAN_POSITIONS)) {
            return [
                'rankings' => $this->buildNationalRankingData($positionCode),
                'rankingsPlatinum' => null
            ];
        }else{
            return [
                'rankings' => $this->buildRankingData($positionCode, Ranking::AWARD_STATUS),
                'rankingsPlatinum' => $this->buildRankingData($positionCode, Ranking::AWARD_PLATINUM)
            ];
        }
    }

    public function buildNationalRankingData(string $positionCode) {
        $currentPeriod = $this->getCurrentPeriod($positionCode);

        $resultsData = Ranking::getNationalRankingsBy([$positionCode], $currentPeriod, 5);

        $rankingOfCurrentUser = $this->getRankingOfCurrentUser($positionCode);
        // if rank of current user is out of 5, then replace 5th with current user's ranking
        if ($rankingOfCurrentUser) {
            if ($rankingOfCurrentUser->rank > 5) {
                $resultsData[4] = $rankingOfCurrentUser;
            }
        }
        return $resultsData->all();
    }

    /**
     * @param string $awardType
     * @return array
     */
    private function buildRankingData(string $positionCode, string $awardType): array {
        /** @var User $currentUser */
        $currentUser = $this->getCurrentUser();
        $currentPeriod = $this->getCurrentPeriod($positionCode);

        $resultsData = Ranking::getRankingsBy([$positionCode], $currentPeriod, $awardType, 5, $currentUser->dealer->state);

        $rankingOfCurrentUser = $this->getRankingOfCurrentUser($positionCode, $awardType);
        // if rank of current user is out of 5, then replace 5th with current user's ranking
        if ($rankingOfCurrentUser) {
            if ($rankingOfCurrentUser->rank > 5) {
                $resultsData[4] = $rankingOfCurrentUser;
            }
        }
        return $resultsData->all();
    }

    /**
     * @return Ranking|null
     */
    public function getCurrentRanking(string $positionCode) {
        $currentPeriod = Ranking::getMaxPeriod($this->currentUser->employee_code, $positionCode);
        if (!$currentPeriod) {
            $thisPeriod = date('Y-m').'-01';
            $currentPeriod = Carbon::createFromFormat('Y-m-d',$thisPeriod);
        }
        $resultData = Ranking::getRankOnlyByEmployeeCode($this->currentUser->employee_code, $currentPeriod);
        return $resultData->first();
    }

//////////////////for ranking page////////////////////////////////////
    /**
     * Generate data array for column 1
     * @return array
     */
    function getUsersGroupsArray1(){
        return [
            [
                'name'   =>'Sales',
                'showAwardType' => true,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-sales',
                'members'=>[
                    [
                        'name'=>'Sales Manager',
                        'role'=>Role::SALES_MANAGER,
                        'className' => 'sales_manager',
                        'awardType' => [
                            Ranking::AWARD_STATUS => true,
                            Ranking::AWARD_PLATINUM => false
                        ]
                    ],[
                        'name'=>'Retail Sales Consultant',
                        'role'=>Role::RETAIL_SALES_CONSULTANTS,
                        'className' => 'retail_sales_consultant',
                        'awardType' => [
                            Ranking::AWARD_STATUS => true,
                            Ranking::AWARD_PLATINUM => true
                        ]
                    ]
                ]
            ],
            [
                'name'=>'Fleet',
                'showAwardType' => true,
                'forAll' => false,
                'style'  => 'font-family: \'nissan_brandlight\', Helvetica, Arial, sans-serif;',
                'className'  => 'button-fleet',
                'members'=>[
                    [
                        'name'=>'Fleet Sales Executive',
                        'role'=>Role::FLEET_SALES_EXECUTIVES,
                        'className' => 'fleet_sales_executive',
                        'awardType' => [
                            Ranking::AWARD_STATUS => true,
                            Ranking::AWARD_PLATINUM => true
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Generate data array for column 2
     * @return array
     */
    function getUsersGroupsArray2(){
        return [
            [
                'name'=>'Service',
                'showAwardType' => false,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-service',
                'members' => [
                    [
                        'name'=>'Service Manager',
                        'role'=>Role::SERVICE_MANAGER
                    ],[
                        'name'=>'Service Advisor',
                        'role'=>Role::SERVICE_ADVISERS
                    ],[
                        'name'=>'Technician Master/Advanced',
                        'role'=>Role::TECHNICIAN
                    ]
                ]
            ],
            [
                'name'=>'Parts',
                'showAwardType' => false,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-parts',
                'members'=>[
                    [
                        'name'=>'Parts Manager',
                        'role'=>Role::PARTS_MANAGER
                    ],[
                        'name'=>'Parts Sales Representative',
                        'role'=>Role::PARTS_SALES_REP
                    ]
                ]
            ]
        ];
    }


    /**
     * Generate data array for bottom
     * @return array
     */
    function getUsersGroupsArray3(){
        return [
            [
                'name'=>'Admin',
                'showAwardType' => false,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-admin',
                'members'=>[
                    [
                        'name'=>'F&I Manager',
                        'role'=>Role::FI
                    ],[
                        'name'=>'Stock Controller',
                        'role'=>Role::STOCK_CONTROLLER
                    ]
                ]
            ]
        ];
    }

    /**
     * @param string $position
     * @param string $type
     * @param string $period
     * @return array
     */
    public function get_ranking(array $positions, string $type, string $period) {

        $result = [];
        $resultsData = Ranking::getRankingsBy($positions, $period, $type)->groupBy('state'); //group by rank state
        $position = count($positions) > 1 ? Role::TECHNICIAN : $positions[0];
        // Loop result set to convert array to new structure for frontend json
        foreach($resultsData as $key => $items){
            $result[$key] = [
                    'title' => $key,
                    'rows' => $items->map(function (object $item, int $key) use ($position) {
                        return $this->_convertRankingRowForFrontendJson($item, 'total', $position);
                    })
                ];
        }
        return $result;
    }

    public function getNationalRankings(array $positions, string $period) {
        $result = [];
        $resultsData = Ranking::getNationalRankingsBy($positions, $period)->groupBy(function (Object $item, int $key) {
            return Position::where('code', $item->position)->first()->title;
        });
        // Loop result set to convert array to new structure for frontend json
        foreach($resultsData as $key => $items) {
            $result[$key] = [
                    'title' => $key,
                    'rows' => $items->map(function (object $item, int $key) {
                        return $this->_convertRankingRowForFrontendJson($item, 'rank', $item->position);
                    })
                ];
        }
        return $result;
    }

    /**
     * Convert database result row array to json array item.
     * It's for reduce the key name length, transfer less data across the internet.
     * @param $item
     * @return array
     */
    private function _convertRankingRowForFrontendJson($item, string $key, string $role){
        return [
            'cn'=>  $this->_parseUserStatusLevel($item[$key], $role),  //  The row's class name
            'r' =>  $item['rank'], // status/platinum rank
            //'rp' =>  $rank ? $rank : $item['rank_platinum'], // rank platinum
            'n' =>  ucfirst($item['firstname']).' '.ucfirst($item['lastname']), // name
            'd' =>  $item['name'], // Dealership
            's' =>  $item['state'], // dealer state for national ranking, otherwise rank state
            'p' =>  number_format($item['total']), // status/platinum points
            'c' =>  $item['category'], // category
            //'cp' =>  number_format($item['total_platinum']), // platinum points
            're'=>  $item['registered'] ? 'YES' : 'NO', // registered
        ];
    }


    /**
     * Get a className for a given role for the style's control in the frontend
     * @param $completed
     * @param $role
     * @return string
     */
    private function _parseUserStatusLevel($completed, string $role){
        /**
         * @var GageStatus $status
         */
        $status = $this->serviceResolver->statusService()->getStatus($completed, $role);
        return $status->getClassString();
    }
}
