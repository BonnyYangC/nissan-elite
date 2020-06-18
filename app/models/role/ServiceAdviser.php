<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 2:03 PM
 */

namespace App\models\role;

use App\models\role\status\IColor;
use App\models\role\status\ServiceAdviserStatus;
use App\models\User;
class ServiceAdviser extends BaseRole implements IRole
{
    public $name='service_adviser';

    // Service adviser: start
    public $serviceRecommendation = [
        'label'=>'Overall Sat',
        'backgroundColor' => IColor::SADDLE_BROWN,
        'data'=>[]
    ];
//    public $advice = [
//        'label'=>'Advice',
//        'backgroundColor' => IColor::DARK_GREY,
//        'data'=>[]
//    ];
//    public $VehicleCleanliness = [
//        'label'=>'Value for Money',
//        'backgroundColor' => IColor::DARK_KHAKI,
//        'data'=>[]
//    ];
    public $INDICATION = [
        'label'=>'Ind W&C',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
//    public $EMW = [
//        'label'=>'EMW',
//        'backgroundColor' => IColor::LOW_RED,
//        'data'=>[]
//    ];
//    public $FFT = [
//        'label'=>'FFT',
//        'backgroundColor' => IColor::DARK_KHAKI,
//        'data'=>[]
//    ];
//    public $SERVICE_YOU_CAN_TRUST = [
//        'label'=>'AYCT',
//        'backgroundColor' => IColor::SILVER,
//        'data'=>[]
//    ];
//    public $CUSTOMER_REPAIR_ORDER = [
//        'label'=>'CPR',
//        'backgroundColor' => IColor::LIGHT_PERU,
//        'data'=>[]
//    ];
    public $EXPLANATION = [
        'label'=>'Exp Costs',
        'backgroundColor' => IColor::LIGHT_GREEN,
        'data'=>[]
    ];
//    public $advice = [
//        'label'=>'ADVICE',
//        'backgroundColor' => IColor::DARK_GREY,
//        'data'=>[]
//    ];
//    public $VehicleCleanliness = [
//        'label'=>'VALUE FOR MONEY',
//        'backgroundColor' => IColor::DARK_KHAKI,
//        'data'=>[]
//    ];
    public $BRAKE_WIPER_SALES = [
        'label'=>'B & K',
        'backgroundColor' => IColor::LIGHT_PINK,
        'data'=>[]
    ];
    public $LOYALTY = [
        'label'=>'Loyalty',
        'backgroundColor' => IColor::RED,
        'data'=>[]
    ];
    
    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->hasPlatinumRanking = false;
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $advice=$advice_results=$emw=$emw_results=$recommendation=$recommendation_results=$fu=$fu_results=$training=$cpr=$cpr_result=[];
        $valueForMoney = $valueForMoneyTable = [];
        $indication=$indication_results=[];
        $explanation=$explanation_results=$brake_wiper=$brake_wiper_results=$loyalty=$loyalty_results=[];
        
        for($i=0; $i<12; $i++) 
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                //1
                $recommendation[] = $this->_buildForJs($item['recom_credit']?$item['recom_credit']:0);
                $recommendation_results[] = $this->_buildForTableElement($item['recom_score']);
//2
//                $valueForMoney[] = $this->_buildForJs($item['fu_credit']?$item['fu_credit']:0);
//                $valueForMoneyTable[] = $this->_buildForTableElement($item['fu_score']).'%';
//2 added for FY2020
                $indication[]                   = $this->_buildForJs($item['indication_credit']);
                $indication_results[]           = $this->_buildForTableElement($item['indication'],1);
                
//3
//                $advice[] = $this->_buildForJs($item['trust_credit']?$item['trust_credit']:0);
//                $advice_results[] = $this->_buildForTableElement($item['trust_score']).'%';
//3 added for FY2020
                $explanation[]                   = $this->_buildForJs($item['ecosts_credit']);
                $explanation_results[]                   = $this->_buildForTableElement($item['ecosts'],1);
//4
//                $cpr[] = $this->_buildForJs($item['cpr_credit']?$item['cpr_credit']:0);
//                $cpr_result[] = $this->_buildForTableElement($item['cpr']*100,1).'%';
//4 added for FY2020
                $brake_wiper[]   = $this->_buildForJs($item['brakewpr_credit']);
                $brake_wiper_results[]    = '$' . $this->_buildForTableElement($item['brakewpr'],2);;
//5 added for FY2020
                $loyalty[]                      = $this->_buildForJs($item['loyaltyser_credit']);
                $loyalty_results[]              = $this->_buildForTableElement(intval($item['loyaltyser']),0);
//6 shifted for FY2020
                // get classroom point from both fields: pathway and classroom
                $classroomTrainingPoints = ($item['pathway']?$item['pathway']:0) + ($item['classroom']?$item['classroom']:0);
                $training[] = $this->_buildForJs(
                    [
                        $item['training']?$item['training']:0,
                        $classroomTrainingPoints,
                        $item['training_competency']?$item['training_competency']:0,
                        $item['train_mastery']?$item['train_mastery']:0
                    ]
                );

                $emw[] = $this->_buildForJs($item['emw_credit']?$item['emw_credit']:0);
                $emw_results[] = $this->_buildForTableElement($item['emw_score'],0);
            }
            else
            {
                $valueForMoney[]   = $this->_buildForJs(0);
                $valueForMoneyTable[]   = null;
                $recommendation[]   = $this->_buildForJs(0);
                $emw[]              = $this->_buildForJs(0);
                $advice[]           = $this->_buildForJs(0);
                $fu[]               = $this->_buildForJs(0);
                $cpr[]               = $this->_buildForJs(0);
                $indication[]       = $this->_buildForJs(0);
                $explanation[]       = $this->_buildForJs(0);
                $brake_wiper[]       = $this->_buildForJs(0);
                $loyalty[]          = $this->_buildForJs(0);
                $training[]         = $this->_buildForJs([0,0,0,0]);

                $advice_results[]           = $this->_buildForTableElement();;
                $emw_results[]              = $this->_buildForTableElement();;
                $recommendation_results[]   = $this->_buildForTableElement();;
                $fu_results[]               = $this->_buildForTableElement();;
                $cpr_result[]               = $this->_buildForTableElement();;
                $indication_results[]       = $this->_buildForTableElement();;
                $explanation_results[]       = $this->_buildForTableElement();;
                $brake_wiper_results[]       = $this->_buildForTableElement();;
                $loyalty_results[]          = $this->_buildForTableElement();;
            }
        }





        return [
            "RECOMMENDATION" => $recommendation,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "VALUE_FOR_MONEY" => $valueForMoney,
            "VALUE_FOR_MONEY_TABLE" => $valueForMoneyTable,
            "ADVICE" => $advice,
            "ADVICE_RESULTS" => $advice_results,
            "EMW" => $emw,
            "EMW_RESULTS" => $emw_results,
            "FOLLOW_UP" => $fu,
            "FOLLOW_UP_RESULTS" => $fu_results,
            "TRAINING" => $training,
            // New field of 2018
            "CPR" => $cpr,
            "CPR_RESULT" => $cpr_result,
            "INDICATION" => $indication,
            "INDICATION_RESULTS" => $indication_results,
            "EXPLANATION"=>$explanation,
            "EXPLANATION_RESULTS"=>$explanation_results,
            "BRAKE_WIPER" => $brake_wiper,
            "BRAKE_WIPER_RESULTS" => $brake_wiper_results,
            "LOYALTY"   => $loyalty,
            "LOYALTY_RESULTS"   => $loyalty_results,
        ];
    }

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName()
    {
        return $this->name;
    }

    /**
     * Retrieve data for dashboard view
     * @param $data
     * @param $ytdParam
     * @return array
     */
    public function getDashboardViewData($data, $ytdParam)
    {
        $ytd = 0;
        $dataResults = $data['Results'];

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,$ytdParam);
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($dataResults[$key]) ? $dataResults[$key] : null;

            if($item)
            {
                $ytd=$item['credit_ytd'];
                $this->JS_credits[date("M", $period)] = $item['credit_mtd']?$item['credit_mtd']:0;
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][]  = intval($item['recom_credit']);
                $this->VehicleCleanliness['data'][]     = intval($item['fu_credit']);
                $this->SERVICE_YOU_CAN_TRUST['data'][]  = intval($item['trust_credit']);
                $this->trainingData['data'][]               = $item['training'] // Training Online
                                                        + $item['pathway']  // credits_training_pathway
                                                        + $item['training_competency']  // competency
                                                        + $item['classroom']
                                                        + $item['train_mastery'];
                $this->CUSTOMER_REPAIR_ORDER['data'][]  = $item['cpr_credit'];
                $this->incentivesForDashboard['data'][] = isset($item['incentive']) && !empty(trim($item['incentive'])) ? intval($item['incentive']) : 0;
                $this->INDICATION['data'][]  = $item['indication_credit'];
                $this->EXPLANATION['data'][]  = $item['ecosts_credit'];
                $this->BRAKE_WIPER_SALES['data'][]  = $item['brakewpr_credit'];
                $this->LOYALTY['data'][]  = $item['loyaltyser_credit'];
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][] = 0;
                $this->VehicleCleanliness['data'][]  = 0;
                $this->SERVICE_YOU_CAN_TRUST['data'][]  = 0;
                $this->trainingData['data'][]  = 0;
                $this->CUSTOMER_REPAIR_ORDER['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
                $this->INDICATION['data'][]  = 0;
                $this->EXPLANATION['data'][]  = 0;
                $this->BRAKE_WIPER_SALES['data'][]  = 0;
                $this->LOYALTY['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }

        // Status
        $status = new ServiceAdviserStatus($ytd);

        return  [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->serviceRecommendation,  //Overall Sat
                //$this->VehicleCleanliness,
                //$this->SERVICE_YOU_CAN_TRUST,
                //$this->CUSTOMER_REPAIR_ORDER,                
                $this->INDICATION,
                $this->EXPLANATION,
                $this->BRAKE_WIPER_SALES,
                $this->LOYALTY,
                $this->trainingData,
                $this->incentivesForDashboard

            ],
            'statusChart'=>[
                'gageArray'=>$status->getGageIndicators(),
                'color'=>$status->getColor(),
                'colorText'=>$status->getColorText(),
                'toReach'=>$status->getToReach(),
                'min'=>$status->getMin(),
                'max'=>$status->getMax(),
            ],
        ];
    }
}