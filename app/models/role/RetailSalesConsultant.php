<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 30/7/18
 * Time: 10:28 AM
 */

namespace App\models\role;

use App\models\role\status\RetailSalesConsultantStatus;
use App\models\User;
use App\models\role\status\IColor;

class RetailSalesConsultant extends BaseRole implements IRole
{
    public $name='retail_sales_consultant';

    public $salesRecommendationSaturation   = [
        'label'=>'Overall Sat.',
        'backgroundColor' => IColor::RED, 
        'data'=>[]
    ];

    public $followUpSaturation             = [
        'label'=>'% Followed up',
        'backgroundColor' => IColor::SILVER,
        'data'=>[]
    ];

    public $pointsActual    =[
        'label'=>'Perf. Target',
        'backgroundColor' => IColor::DARK_KHAKI,
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->hasPlatinumRanking = true;
    }

    /**
     * Retrieve data for dashboard view
     * @param $data
     * @param $ytdParam
     * @return array
     */
    public function getDashboardViewData($data, $ytdParam)
    {
        // TODO: Implement getDashboardViewData() method.
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
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'].'';

                /**
                 * From Data results
                 */
                $this->newVehicleSales['data'][] = intval($item['credit_actual_sales']+$item['points_actual']);
                $this->salesRecommendationSaturation['data'][]  = intval($item['salesperson_satisfaction_score']);
                $this->followUpSaturation['data'][]  = intval($item['follow_up_satisfaction_score']);
                $this->pointsActual['data'][]  = intval($item['points_actual']);  // Perf. Target
                $this->keptInformed['data'][]  = intval($item['kept_informed_delivery_score']);
                $this->trainingData['data'][]  = $item['training'] // Online
                    + $item['pathway'] + $item['training_competency'];
                $this->incentivesForDashboard['data'][] = empty(trim($item['incentive'])) ? 0 : intval($item['incentive']);
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;

                /**
                 * From Data results
                 */
                $this->newVehicleSales['data'][]  = 0;
                $this->salesRecommendationSaturation['data'][]  = 0;
                $this->followUpSaturation['data'][]  = 0;
                $this->pointsActual['data'][]  = 0;
                $this->keptInformed['data'][]  = 0;
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }

        // Status
        $status = new RetailSalesConsultantStatus($ytd);

        $result = [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->newVehicleSales,
                $this->salesRecommendationSaturation,
                $this->pointsActual,
                $this->keptInformed,
                $this->followUpSaturation,
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
//            'rankingNationally'=> $rankingNationally,
//            'rankingRegionally'=> $myRegionallyRanking,
        ];

        return $result;
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $new=$salespersonSatisfactionScore=$followUpSatisfactionScore=$keptInformedDeliveryScore=$training=$sales_results=$salespersonSatisfaction=$followUpSatisfaction=$keptInformedDelivery=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                //1
                //$new[]               = $this->_buildForJs($item['credit_actual_sales']);
                $new[]                          = $this->_buildForJs([         $item['credit_actual_sales'], $item['points_actual']]);
                $sales_results[]                = $this->_buildForTableElement($item['sales'],0);
                $percentage_actual_results[]    = $this->_buildForTableElement(intval($item['percentage_actual']*100),0).'%';

                //2
                $salespersonSatisfactionScore[] = $this->_buildForJs(          $item['salesperson_satisfaction_score']);
                $salespersonSatisfaction[]      = $this->_buildForTableElement($item['salesperson_satisfaction']);
                //3
                $keptInformedDeliveryScore[]    = $this->_buildForJs(          $item['kept_informed_delivery_score']);
                $keptInformedDelivery[]         = $this->_buildForTableElement($item['kept_informed_delivery']);
                //4
                $followUpSatisfaction[]         = $this->_buildForTableElement($item['follow_up_satisfaction']);
                $followUpSatisfactionScore[]    = $this->_buildForJs(          $item['follow_up_satisfaction_score']);
                //5
                $training[]                     = $this->_buildForJs([         $item['training'],$item['pathway'],$item['training_competency']]);

            }
            else
            {
                //$new[]              = $this->_buildForJs(0);
                $new[]                          = $this->_buildForJs([0,0]);
                $salespersonSatisfactionScore[] = $this->_buildForJs(0);
                $followUpSatisfactionScore[]    = $this->_buildForJs(0);
                $keptInformedDeliveryScore[]    = $this->_buildForJs(0);
                $followUpCreditSAT[]            = $this->_buildForJs(0);
                $training[]                     = $this->_buildForJs([0,0,0]);

                $sales_results[]             = null;
                $percentage_actual_results[] = null;
                $salespersonSatisfaction[]   = null;
                $keptInformedDelivery[]      = null;
                $followUpSatisfaction[]      = null;
            }
        }

        return [
            // For js array
            "JS_newVehicleSales"            => $new,
            "JS_salespersonSatisfaction"    => $salespersonSatisfactionScore, //
            "JS_keptInformedDelivery"       => $keptInformedDeliveryScore,
            "JS_followUpSatisfaction"       => $followUpSatisfactionScore,

            "JS_training"                   => $training,

            // For PHP array
            "salesResult"                   => $sales_results,
            "percentageActual"              => $percentage_actual_results,
            "salespersonSatisfaction"       => $salespersonSatisfaction,
            "keptInformedDelivery"          => $keptInformedDelivery,
            "followUpSatisfaction"          => $followUpSatisfaction,
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


}
