<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 1:07 PM
 */

namespace App\controller;


use App\core\JsonBuilder;
use Klein\Request;
use Klein\Response;
use App\models\User;
use App\models\nissan\Ranking;

class RankingsController extends DashboardController
{

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function get_rankings(){
        $result = [];
        $modalTitle = 'YTD ';

        if($this->userObject){
            $role = $this->request->param('role');
            list($period, $region) = explode(' ',$this->request->param('action'));

            $thisPeriod = $this->_getThisPeriod($this->userObject);

            if($period == Ranking::PREVIOUS){
                // 表示从查询到的 $thisPeriod 的上个月1号开始计算
                $thisPeriod->subMonth(1);
            }
            $modalTitle .= $thisPeriod->format('F Y');

            $resultSet = Ranking::GetByRole($role,$thisPeriod,$region);

            foreach ($resultSet as $key => $item) {
                if(!isset($result[$item['category']])){
                    $result[$item['category']] = [];
                    $result[$item['category']]['category'] = 'Category '.$item['category'];
                    $result[$item['category']]['rows'] = [];
                }
                $result[$item['category']]['rows'][] = [
                    'r' => $region===Ranking::NATIONAL ? $item['ranking'] : count($result[$item['category']]['rows'])+1, // rank
                    'n' =>ucfirst($item['firstname']).' '.ucfirst($item['lastname']), // name
                    'd' =>$item['company_name'], // Dealership
                    's' =>$item['company_state'], // state
                    'c' => number_format(floatval($item['total'])), // credits
                    're'=> $item['registered'] // registered
                ];
            }

//            dd($result);
        }

//        $result[] = [
//            'category'=>'Category A',
//            'rows'=>[
//                [
//                    'r' =>1, // rank
//                    'n' =>'Some One', // name
//                    'd' =>'Ha ha ha', // Dealership
//                    's' =>'QLD', // state
//                    'c' => 1000, // credits
//                    're'=>1 // registered
//                ],
//                [
//                    'r' =>1, // rank
//                    'n' =>'Some One', // name
//                    'd' =>'Ha ha ha', // Dealership
//                    's' =>'QLD', // state
//                    'c' => 1000, // credits
//                    're'=>'YES' // registered
//                ]
//            ]
//        ];

        echo JsonBuilder::Success(['blocks'=>array_values($result),'modalTitle'=>$modalTitle]);
    }

    /**
     * Load leader boards view
     */
    public function leader_boards(){
        $this->dataForView['currentUri'] = 'LeaderBoards';

        /**
         * 方便的产生
         */
        $this->dataForView['rankingForAll'] = [
            'Current National','Current Regional','Previous National','Previous Regional'
        ];
        $this->dataForView['rankingForNationalOnly'] = [
            'Current National','Previous National'
        ];

        $this->dataForView['userGroups1'] = $this->_getUsersGroupsArray1();
        $this->dataForView['userGroups2'] = $this->_getUsersGroupsArray2();

        $this->render('dashboard/static/leader_boards');
        return;
    }

    private function _getUsersGroupsArray2(){
        return [
            [
                'name'=>'Parts',
                'forAll' => false,
                'style'  => '',
                'className'  => 'button-parts',
                'members'=>[
                    [
                        'name'=>'Parts Manager','role'=>User::PARTS_MANAGER
                    ],[
                        'name'=>'Parts Sales Representative','role'=>User::PARTS_SALES_REP
                    ]
                ]
            ],[
                'name'=>'Admin',
                'forAll' => false,
                'style'  => '',
                'className'  => 'button-admin',
                'members'=>[
                    [
                        'name'=>'F&I Manager','role'=>User::FI
                    ],[
                        'name'=>'Financial Controller','role'=>User::FINANCE_CONTROLLER
                    ],[
                        'name'=>'Stock Controller','role'=>User::STOCK_CONTROLLER
                    ]
                ]
            ]
        ];
    }

    private function _getUsersGroupsArray1(){
        return [
            [
                'name'   =>'Sales',
                'forAll' => true,
                'style'  => '',
                'className'  => 'button-sales',
                'members'=>[
                    [
                        'name'=>'Sales Manager','role'=>User::SALES_MANAGER
                    ],[
                        'name'=>'Retail Sales Consultant','role'=>User::RETAIL_SALES_CONSULTANTS
                    ],[
                        'name'=>'Fleet Manager/Sales Consultant','role'=>User::FLEET_SALES_MANAGER.'+'.User::FLEET_SALES_CONSULTANTS
                    ]
                ]
            ],
            [
                'name'=>'Service',
                'forAll' => false,
                'style'  => 'font-family: \'nissan_brandbold\', Helvetica, Arial, sans-serif;',
                'className'  => 'button-service',
                'members'=>[
                    [
                        'name'=>'Service Manager','role'=>User::SERVICE_MANAGER
                    ],[
                        'name'=>'Service Advisor','role'=>User::SERVICE_ADVISERS
                    ]
                ]
            ]
        ];
    }
}