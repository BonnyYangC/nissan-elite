<?php

namespace App\Services;

use App\Helper\Role;
use App\Models\{Ranking, User};
use App\Services\StatusServices\GageStatus;
use Carbon\Carbon;

class RankingService extends BaseService {

    /**
     * @return array
     */
    public function getLeadBoardData(): array {
        // 获取了所有的 Rankings: Get all rankings
        $rankings = $this->buildRankingData(Ranking::AWARD_STATUS);
        $rankingsPlatinum = $this->buildRankingData(Ranking::AWARD_PLATINUM);

        return compact('rankings', 'rankingsPlatinum');
    }

    /**
     * @param string $type
     * @return array
     */
    public function buildRankingData(string $type): array {
        /** @var User $currentUser */
        $currentUser = $this->getCurrentUser();
        $currentPeriod = Ranking::getMaxPeriod($currentUser->employee_code);
        if (!$currentPeriod) {

            $thisPeriod = date('Y-m').'-01';
            $currentPeriod = Carbon::createFromFormat('Y-m-d',$thisPeriod);
        }
        $resultsData = Ranking::getRankingsBy($currentUser->position_code, $currentPeriod, $type, 5, $currentUser->dealer->state);

        $rankingOfCurrentUser = Ranking::getRankingByEmployeeCode($currentUser->employee_code, $currentPeriod, $type)->first();
        // if rank of current user is out of 5, then replace 5th with current user's ranking
        if ($rankingOfCurrentUser) {
            $rank = $type === Ranking::AWARD_STATUS ? $rankingOfCurrentUser->rank : $rankingOfCurrentUser->rank_platinum;
            if ($rank > 5) {
                $resultsData[4] = $rankingOfCurrentUser;
            }
        }
        return $resultsData->all();
    }

    /**
     * @return Ranking|null
     */
    public function getCurrentRanking() {
        $currentPeriod = Ranking::getMaxPeriod($this->currentUser->employee_code);
        if (!$currentPeriod) {
            $thisPeriod = date('Y-m').'-01';
            $currentPeriod = Carbon::createFromFormat('Y-m-d',$thisPeriod);
        }
        $resultData = Ranking::getRankByEmployeeCode($this->currentUser->employee_code, $currentPeriod);
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
                'members'=>[
                    [
                        'name'=>'Service Manager',
                        'role'=>Role::SERVICE_MANAGER
                    ],[
                        'name'=>'Service Advisor',
                        'role'=>Role::SERVICE_ADVISERS
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
    public function get_ranking(string $position, string $type, string $period) {

        $result = [];
        $resultsData = Ranking::getRankingsBy($position, $period, $type)->all();

        // Loop result set to convert array to new structure for frontend json

        $currentRankState = null;
        foreach($resultsData as $key => $item){
            $item['total'] = floatval($item['total']);
            if($currentRankState !== $item['rank_state']){
                $currentRankState = $item['rank_state'];
            }

            if(!isset($result[$currentRankState])){
                $result[$currentRankState] = [];
                $result[$currentRankState]['rows'] = [];
            }

            $result[$currentRankState]['rank_state'] = $currentRankState;
            $result[$currentRankState]['rows'][] = $this->_convertRankingRowForFrontendJson(
                $item,
                $position
            );
        }
        return $result;
    }

    /**
     * Convert database result row array to json array item.
     * It's for reduce the key name length, transfer less data across the internet.
     * @param $item
     * @param $role
     * @return array
     */
    private function _convertRankingRowForFrontendJson($item, $role){
        return [
            'cn'=>  $this->_parseUserStatusLevel($item['total'], $role),  //  The row's class name
            'r' =>  $item['rank'], // status/platinum rank
            //'rp' =>  $rank ? $rank : $item['rank_platinum'], // rank platinum
            'n' =>  ucfirst($item['firstname']).' '.ucfirst($item['lastname']), // name
            'd' =>  $item['name'], // Dealership
            's' =>  $item['rank_state'], // state
            'p' =>  number_format($item['total']), // status/platinum points
            'c' =>  $item['category'], // category
            //'cp' =>  number_format($item['total_platinum']), // platinum points
            're'=>  $item['registered'] ? 'YES' : 'NO', // registered
        ];
    }


    /**
     * Get a className for a given role for the style's control in the frontend
     * @param $credits
     * @param $role
     * @return string
     */
    private function _parseUserStatusLevel($credits, $role){
        /**
         * @var GageStatus $status
         */
        $status = $this->serviceResolver->statusService()->getStatus($credits, $role);
        return $status->getClassString();
    }
}
