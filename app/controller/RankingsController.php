<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 1:07 PM
 */

namespace App\controller;

use App\core\JsonBuilder;
use App\models\Company;
use App\models\role\status\FinanceControllerStatus;
use App\models\role\status\FiStatus;
use App\models\role\status\GageStatus;
use App\models\role\status\PartsSalesRepStatus;
use App\models\role\status\RetailSalesConsultantStatus;
use App\models\role\status\SalesManagerStatus;
use App\models\role\status\ServiceAdviserStatus;
use App\models\role\status\ServiceManagerStatus;
use App\models\role\status\StockControllerStatus;
use Klein\Request;
use Klein\Response;
use App\models\User;
use App\models\nissan\Ranking;
use League\Csv\Writer;

class RankingsController extends DashboardController
{

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Print rankings
     */
    public function print_rankings(){
        return $this->get_rankings(true);
    }

    /**
     * Get rankings data in Json format According to the request
     * @param bool $isPrintAction
     */
    public function get_rankings($isPrintAction = false){
        $result = [];
        $modalTitle = 'YTD ';

        if($this->userObject){

            $role = trim( $this->request->param('role') );
            list($period, $region) = explode(' ',$this->request->param('action'));
            $awardType = $this->request->param('type') ? $this->request->param('type') : Ranking::AWARD_STATUS;

            $thisPeriod = $this->_getThisPeriod($this->userObject, $role);

            if($period == Ranking::PREVIOUS){
                // 表示从查询到的 $thisPeriod 的上个月1号开始计算
                $thisPeriod->subMonth(1);
            }

            $modalTitle .= $thisPeriod->format('F Y');
            $modalTitle .= ' - '.$awardType;

            // Retrieve result set from database
            $resultSet = Ranking::GetByRoleAndAwardType(
                $role, //$isFleetSalesOrFleetSalesManager ? $role[0] : $role,
                $awardType,
                $thisPeriod
            );

            // Loop result set to convert array to new structure for frontend json

            $currentRankState = null;
            foreach($resultSet as $key => $item){
                $item['total'] = floatval($item['total']);
                if($currentRankState !== $item['rank_state']){
                    $currentRankState = $item['rank_state'];
                }

                if(!$result[$currentRankState]){
                    $result[$currentRankState] = [];
                    $result[$currentRankState]['rows'] = [];
                }

                $result[$currentRankState]['rank_state'] = $currentRankState;
                $result[$currentRankState]['rows'][] = $this->_convertRankingRowForFrontendJson(
                    $item,
                    $role
                );

            }

            if($isPrintAction){
                // Print as csv file
                return $this->_printRankingsInCsv($result, $awardType);
            }else{
                // Not print
                echo JsonBuilder::Success([
                    'blocks'=>array_values($result),
                    'modalTitle'=>$modalTitle
                ]);
            }
        }
        else{
            echo JsonBuilder::Error();
        }
    }

    private function _printRankingsInCsv($result, $type){
        $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.$type.'rankings'.time().'.csv';
        $fileStream = fopen($filePath,'w');

        $writer = Writer::createFromStream($fileStream);

        $csvHeader = [
            'Rank',
            'Name',
            'Dealer',
            'Category',
            'State',
            $type == Ranking::AWARD_STATUS ? 'Points' : 'Points Platinum',
            'Registered', 
        ];
        $writer->insertOne($csvHeader);
        foreach ($result as $categoryName=>$rows){
            foreach ($rows['rows'] as $row) {
                $record = [
                    $row['r'],
                    $row['n'],
                    $row['d'],
                    $row['c'],
                    $row['s'],
                    str_replace(',','',$row['p']),
                    $row['re'],
                ];
                $writer->insertOne(implode(',',$record));
            }
        }

        fclose($fileStream);

        $this->response->file($filePath,null,'csv');
        return;
    }

    /**
     * Convert database result row array to json array item.
     * It's for reduce the key name length, transfer less data across the internet.
     * @param $item
     * @param $role
     * @return array
     */
    private function _convertRankingRowForFrontendJson($item, $role){
        
        //registered
        $re = null;
        if(in_array($item['registered'],['NO', '0']) || empty($item['registered'])){
            $re = 'NO';
        }
        
        if(in_array($item['registered'],['YES', 'registered', 'Registered'])){
            $re = 'YES';
        }

        return [
            'cn'=>  $this->_parseUserStatusLevel($item['total'], $role),  //  The row's class name
            'r' =>  $item['rank'], // status/platinum rank
            //'rp' =>  $rank ? $rank : $item['rank_platinum'], // rank platinum
            'n' =>  ucfirst($item['firstname']).' '.ucfirst($item['lastname']), // name
            'd' =>  $item['company_name'], // Dealership
            's' =>  $item['company_state'], // state
            'p' =>  number_format($item['total']), // status/platinum points
            'c' =>  $item['category'], // category
            //'cp' =>  number_format($item['total_platinum']), // platinum points
            're'=>  $re, // registered
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
        $status = null;

        switch ($role){
            case User::FI:
                $status = new FiStatus($credits);
                break;
            case User::FINANCE_CONTROLLER:
                $status = new FinanceControllerStatus($credits);
                break;
            case User::PARTS_MANAGER:
                $status = new PartsSalesRepStatus($credits);
                break;
            case User::RETAIL_SALES_CONSULTANTS:
                //$this->hasPlatinumRanking = true;
                $status = new RetailSalesConsultantStatus($credits);
                break;
            case User::FLEET_SALES_EXECUTIVES:
                //$this->hasPlatinumRanking = true;
                $status = new RetailSalesConsultantStatus($credits);
                break;
            case User::SALES_MANAGER:
                $status = new SalesManagerStatus($credits);
                break;
            case User::STOCK_CONTROLLER:
                $status = new StockControllerStatus($credits);
                break;
            case User::PARTS_SALES_REP:
                $status = new PartsSalesRepStatus($credits);
                break;
            case User::SERVICE_MANAGER:
                $status = new ServiceManagerStatus($credits);
                break;
            case User::SERVICE_ADVISERS:
                $status = new ServiceAdviserStatus($credits);
                break;
            default:
                break;
        }
        return $status->getClassString();
    }

    /**
     * Load leader boards view
     * URI: /dashboard/Leaderboards
     */
    public function leader_boards(){
        $this->dataForView['currentUri'] = 'LeaderBoards';
        /**
         * 方便的产生
         */
        //for Sales Manager, Retail Sales Consultant and Fleet Sales Executive
        $this->dataForView['rankingForAll'] = [
            Ranking::CURRENT,
            Ranking::PREVIOUS
            /*Ranking::CURRENT.' '.Ranking::NATIONAL,
            Ranking::CURRENT.' '.Ranking::STATE, 
            Ranking::PREVIOUS.' '.Ranking::NATIONAL,
            Ranking::PREVIOUS.' '.Ranking::STATE*/
        ];
        //for All other roles
        $this->dataForView['rankingForNationalOnly'] = [
            Ranking::CURRENT.' '.Ranking::NATIONAL, 
            Ranking::PREVIOUS.' '.Ranking::NATIONAL
        ];

        $this->dataForView['userGroups1'] = $this->_getUsersGroupsArray1();
        $this->dataForView['userGroups2'] = $this->_getUsersGroupsArray2();
        $this->dataForView['userGroups3'] = $this->_getUsersGroupsArray3();

        $this->dataForView['awardType'] = [Ranking::AWARD_STATUS, Ranking::AWARD_PLATINUM];

        $this->render('dashboard/static/leader_boards');
        return;
    }

    /**
     * Generate data array for column 1
     * @return array
     */
    private function _getUsersGroupsArray1(){
        return [
            [
                'name'   =>'Sales',
                'showAwardType' => true,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-sales',
                'members'=>[
                    [
                        'name'=>'Sales Manager','role'=>User::SALES_MANAGER, 
                        'className' => 'sales_manager',
                        'awardType' => [
                            Ranking::AWARD_STATUS => true,
                            Ranking::AWARD_PLATINUM => false
                        ]
                    ],[
                        'name'=>'Retail Sales Consultant','role'=>User::RETAIL_SALES_CONSULTANTS,
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
                        'name'=>'Fleet Sales Executive','role'=>User::FLEET_SALES_EXECUTIVES,
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
    private function _getUsersGroupsArray2(){
        return [
            [
                'name'=>'Service',
                'showAwardType' => false,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-service',
                'members'=>[
                    [
                        'name'=>'Service Manager','role'=>User::SERVICE_MANAGER
                    ],[
                        'name'=>'Service Advisor','role'=>User::SERVICE_ADVISERS
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
                        'name'=>'Parts Manager','role'=>User::PARTS_MANAGER
                    ],[
                        'name'=>'Parts Sales Representative','role'=>User::PARTS_SALES_REP
                    ]
                ]
            ]
        ];
    }


    /**
     * Generate data array for bottom
     * @return array
     */
    private function _getUsersGroupsArray3(){
        return [
[
                'name'=>'Admin',
                'showAwardType' => false,
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-admin',
                'members'=>[
                    [
                        'name'=>'F&I Manager','role'=>User::FI
                    ],[
                        'name'=>'Stock Controller','role'=>User::STOCK_CONTROLLER
                    ]
                ]
            ]
        ];
    }

}
