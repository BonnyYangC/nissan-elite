<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 10:14 AM
 */

namespace App\models\role;

use App\models\role\status\ServiceManagerStatus;
use App\models\User;
use Carbon\Carbon;
use App\models\role\status\IColor;

class ServiceManager extends BaseRole implements IRole
{
    public $name='service_manager';

    public $serviceRecommendation = [
        'label'=>'Overall Sat',
        'backgroundColor' => IColor::SADDLE_BROWN,
        'data'=>[]
    ];
//    public $VehicleCleanliness = [
//        'label'=>'Value for Money',
//        'backgroundColor' => IColor::DARK_KHAKI,
//        'data'=>[]
//    ];

    public $FFT = [
        'label'=>'F1',
        'backgroundColor' => IColor::SILVER,
        'data'=>[]
    ];
    public $EXPLANATION = [
        'label'=>'Exp Costs',
        'backgroundColor' => IColor::DARK_KHAKI,
        'data'=>[]
    ];
    public $CUSTOMER_REPAIR_ORDER = [
        'label'=>'CPRO',
        'backgroundColor' => IColor::LIGHT_PERU,
        'data'=>[]
    ];
    public $RETENTION = [
        'label'=>'Retention',
        'backgroundColor' => IColor::STEEL_BLUE,
        'data'=>[]
    ];
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
        $recommendation=$recommendation_results=$clean=$clean_results=$fu=$fu_results=$emw=$emw_results=$training=[];
        $customerPaidRepairCredits = [];
        $customerPaidRepair = [];
        $explanation=$explanation_results=$retention=$retention_results=$brake_wiper=$brake_wiper_results=$loyalty=$loyalty_results=[];

        /**
         * @var Carbon $startPoint
         */
        $startPoint = $this->startPoint;

        for($i=0; $i<12; $i++) 
        {
            $key = $startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                //1
                $recommendation[]       = $this->_buildForJs($item['recommendation_credit']);
                $recommendation_results[]       = $this->_buildForTableElement($item['recommendation'],1);
//2 retired for FY2020
//                $clean[]                = $this->_buildForJs($item['vclean_credit']);
//                $clean_results[]                = $this->_buildForTableElement($item['vclean'],1).'%';
//2 updated for FY2020
                $fu[]                   = $this->_buildForJs($item['followup_credit']);
                $fu_results[]                   = $this->_buildForTableElement($item['followup'],1);
//3 added for FY2020
                $explanation[]          = $this->_buildForJs($item['ecosts_credit']);
                $explanation_results[]           = $this->_buildForTableElement($item['ecosts'],1);
//4
                $customerPaidRepair[]   = $this->_buildForJs($item['cpr_credit']);
                $customerPaidRepairCredits[]    = $this->_buildForTableElement($item['cpr']*100,1) .'%';
//5 added for FY2020
                $retention[]            = $this->_buildForJs($item['retention_credit']);
                $retention_results[]    = $this->_buildForTableElement($item['retention'],1) .'%';
//6 added for FY2020
                $brake_wiper[]              = $this->_buildForJs($item['brakewpr_credit']);
                $brake_wiper_results[]      = '$' . $this->_buildForTableElement($item['brakewpr'],2);
//7 added for FY2020
                $loyalty[]                      = $this->_buildForJs($item['loyaltyser_credit']);
                $loyalty_results[]              = $this->_buildForTableElement(intval($item['loyaltyser']),0);
//8 updated for FY2020                
                $training[]             = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency'],$item['training_bonus']]);
/*
                $emw[]                  = $this->_buildForJs($item['emw_credit']);
                $emw_results[]                  = $this->_buildForTableElement($item['emw'],0);*/
            }
            else
            {
                $customerPaidRepair[]   = $this->_buildForJs(0);
                $recommendation[]       = $this->_buildForJs(0);
                //$clean[]                = $this->_buildForJs(0);
                $fu[]                   = $this->_buildForJs(0);
                $explanation[]            = $this->_buildForJs(0);
                $retention[]            = $this->_buildForJs(0);
                $brake_wiper[]            = $this->_buildForJs(0);
                $loyalty[]              = $this->_buildForJs(0);
               // $emw[]                  = $this->_buildForJs(0);
                $training[]             = $this->_buildForJs([0,0,0,0]);

                $customerPaidRepairCredits[]    = $this->_buildForTableElement();
                $recommendation_results[]       = $this->_buildForTableElement();
                //$clean_results[]                = $this->_buildForTableElement();
                $fu_results[]                   = $this->_buildForTableElement();
                $explanation_results[]            = $this->_buildForTableElement();
                $retention_results[]            = $this->_buildForTableElement();
                $brake_wiper_results[]            = $this->_buildForTableElement();
                $loyalty_results[]                = $this->_buildForTableElement();
               // $emw_results[]                  = $this->_buildForTableElement();
            }

        }
        $metrics = [
            "RECOMMENDATION" => $recommendation,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            //"CLEAN" => $clean,
            //"CLEAN_RESULTS" => $clean_results,
            "FOLLOWUP" => $fu,
            "FOLLOWUP_RESULTS" => $fu_results,
            /*"EMW" => $emw,
            "EMW_RESULTS" => $emw_results,*/
            "TRAINING" => $training,
            "EXPLANATION" => $explanation,
            "EXPLANATION_RESULTS" => $explanation_results,
            "CUSTOMER_PAID_REPAIR" => $customerPaidRepair,
            "customerPaidRepairCredits" => $customerPaidRepairCredits,
            "RETENTION" => $retention,
            "RETENTION_RESULTS" => $retention_results,
            "BRAKE_WIPER" => $brake_wiper,
            "BRAKE_WIPER_RESULTS" => $brake_wiper_results,
            "LOYALTY"   => $loyalty,
            "LOYALTY_RESULTS"   => $loyalty_results,
        ];
        return $metrics;
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
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'];
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][]  = intval($item['recommendation_credit']);
                //$this->VehicleCleanliness['data'][]     = intval($item['vclean_credit']);
                $this->FFT['data'][]     = intval($item['followup_credit']);
                //$this->EMW['data'][]                    = intval($item['emw_credit']);
                $this->trainingData['data'][]               = $item['training']
                    + $item['pathway']
                    + $item['training_competency'];
                $this->CUSTOMER_REPAIR_ORDER['data'][]  = $item['cpr_credit'];
                $this->EXPLANATION['data'][]  = $item['ecosts_credit'];
                $this->RETENTION['data'][]  = $item['retention_credit'];
                $this->BRAKE_WIPER_SALES['data'][]  = $item['brakewpr_credit'];
                $this->LOYALTY['data'][]  = intval($item['loyaltyser_credit']);
                $this->incentivesForDashboard['data'][] = isset($item['incentive']) && !empty(trim($item['incentive'])) ? intval($item['incentive']) : 0;
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][] = 0;
                //$this->VehicleCleanliness['data'][]  = 0;
                $this->FFT['data'][]  = 0;
                //$this->EMW['data'][]  = 0;
                $this->trainingData['data'][]  = 0;
                $this->CUSTOMER_REPAIR_ORDER['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
                $this->EXPLANATION['data'][]  = 0;
                $this->RETENTION['data'][]  = 0;
                $this->BRAKE_WIPER_SALES['data'][]  = 0;
                $this->LOYALTY['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }

        // Status
        $status = new ServiceManagerStatus($ytd);

        $result = [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->serviceRecommendation,
                //$this->VehicleCleanliness,
                $this->FFT,
                $this->CUSTOMER_REPAIR_ORDER,
                //$this->EMW,
                $this->trainingData,
                $this->incentivesForDashboard,
                $this->EXPLANATION,
                $this->RETENTION,
                $this->BRAKE_WIPER_SALES,
                $this->LOYALTY,
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
        return $result;
    }

}